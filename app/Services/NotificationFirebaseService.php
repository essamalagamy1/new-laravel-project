<?php

namespace App\Services;

use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationFirebaseService
{
    /**
     * Send a notification to a specific user via Firebase FCM v1.
     *
     * @param  User|int  $user
     * @param  array{title?: string, body?: string, type?: array{id?: string|int, name?: string, procedure?: string}}  $data
     */
    public static function send($user, array $data): void
    {
        // If $user is an ID, fetch the user model
        if (! $user instanceof User) {
            $user = User::find($user);
        }

        // Retrieve token from the user model (since it is not stored in personal_access_tokens in this project)
        $token = $user?->fcm_token;
        // user disable_notifications
        if ($user?->disable_notifications) {
            Log::info('User has disabled notifications, skipping FCM send', ['user_id' => $user->id]);

            return;
        }

        if (empty($token)) {
            Log::warning('User not found or FCM token missing', ['user_id' => $user->id ?? $user]);

            return;
        }

        try {
            $credentialsFilePath = storage_path('app/json/fcm.json');

            if (! file_exists($credentialsFilePath)) {
                Log::error('Firebase credentials file not found', ['path' => $credentialsFilePath]);

                return;
            }

            $client = new GoogleClient;
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();
            $tokenResult = $client->getAccessToken();

            if (! $tokenResult || ! isset($tokenResult['access_token'])) {
                Log::error('Failed to get access token from Google Client');

                return;
            }

            $access_token = $tokenResult['access_token'];
            $credentials = json_decode(file_get_contents($credentialsFilePath), true);
            $projectId = $credentials['project_id'] ?? config('fcm.project_id');

            if (empty($projectId)) {
                Log::error('Firebase project ID not found in credentials or config');

                return;
            }

            $apiUrl = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            $messagePayload = [
                'token' => $token,
                'notification' => [
                    'title' => $data['title'] ?? '',
                    'body' => $data['body'] ?? '',
                ],
                'android' => [
                    'priority' => 'high', // لضمان وصول التنبيه فوراً واهتزاز الجهاز
                    'notification' => [
                        'sound' => 'default',
                        'vibrate_timings' => [
                            '0s',     // تأخير البداية
                            '0.5s',   // مدة الاهتزاز الأول
                            '0.2s',   // مدة التوقف
                            '0.5s',   // مدة الاهتزاز الثاني
                            '0.2s',   // مدة التوقف
                            '1s',      // اهتزاز طويل في النهاية
                        ],
                        'notification_priority' => 'PRIORITY_MAX', // أعلى أولوية للتنبيه
                        'default_vibrate_timings' => false, // تعطيل النمط الافتراضي لاستخدام النمط المخصص
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                            'content-available' => 1,
                        ],
                    ],
                ],
            ];

            if (! empty($data['data']) && is_array($data['data'])) {
                $messagePayload['data'] = array_map(function ($value) {
                    return is_array($value) || is_object($value) ? json_encode($value) : strval($value);
                }, $data['data']);
            }

            $payload = [
                'message' => $messagePayload,
            ];

            $response = Http::withHeaders([
                'Authorization' => "Bearer $access_token",
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            if ($response->failed()) {
                $responseBody = $response->json();
                $errorCode = $responseBody['error']['details'][0]['errorCode'] ?? null;

                // If token is unregistered, clear it from database
                if ($errorCode === 'UNREGISTERED') {
                    Log::warning('FCM token is unregistered, clearing from database', [
                        'user_id' => $user->id,
                        'token' => $token,
                    ]);

                    $user->update(['fcm_token' => null]);
                }

                Log::error('FCM notification failed', [
                    'user_id' => $user->id,
                    'token' => $token,
                    'status' => $response->status(),
                    'error_code' => $errorCode,
                    'response' => $response->body(),
                ]);
            } else {
                Log::info('FCM notification sent successfully', [
                    'user_id' => $user->id,
                    'response' => $response->json(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('FCM notification exception', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
