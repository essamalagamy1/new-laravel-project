<?php

namespace App\Services;

use Abdulbaset\ZoomIntegration\ZoomIntegrationService;
use Carbon\CarbonImmutable;

class ZoomService
{
    private static ?ZoomIntegrationService $zoomInstance = null;

    private static array $meetingData = [];

    /**
     * Initialize Zoom service with configuration
     */
    private static function init(): void
    {
        if (self::$zoomInstance === null) {
            self::$zoomInstance = new ZoomIntegrationService(
                config('services.zoom.account_id'),
                config('services.zoom.client_id'),
                config('services.zoom.client_secret')
            );

            self::$meetingData = [
                'type' => 2,
                'settings' => [
                    'watermark' => true,
                    'join_before_host' => false,
                    'auto_recording' => 'local',
                    'mute_upon_entry' => true,
                    'approval_type' => 0,
                    'enforce_login' => false,
                    'allow_multiple_devices' => false,
                    'request_permission_to_unmute_participants' => true,
                    'waiting_room' => true,
                    'waiting_room_options' => [
                        'mode' => 'custom',
                        'who_goes_to_waiting_room' => 'users_not_on_invite',
                    ],
                    'password' => '',       // تعطيل كلمة المرور
                ],
            ];
        }
    }

    /**
     * Prepare meeting data with common fields
     */
    private static function prepareMeetingData(string $topic, string $start_time, string $timezone, array $additionalData = []): array
    {
        return array_merge(self::$meetingData, $additionalData, [
            'topic' => $topic,
            'agenda' => $topic,
            'start_time' => CarbonImmutable::parse($start_time, $timezone)
                ->utc()
                ->toIso8601String(),
            'timezone' => $timezone,
        ]);
    }

    /**
     * Create a new Zoom meeting
     */
    public static function createMeeting(string $topic, string $start_time, string $timezone = 'UTC', array $data = []): array
    {
        self::init();
        $meetingData = self::prepareMeetingData($topic, $start_time, $timezone, $data);

        return self::$zoomInstance->createMeeting($meetingData);
    }

    /**
     * Get details of an existing Zoom meeting
     */
    public static function getMeeting(int $zoom_id): array
    {
        self::init();

        return self::$zoomInstance->getMeeting($zoom_id);
    }

    /**
     * Update an existing Zoom meeting
     */
    public static function updateMeeting(int $zoom_id, string $topic, string $start_time, string $timezone = 'UTC', array $data = []): array
    {
        self::init();
        $meetingData = self::prepareMeetingData($topic, $start_time, $timezone, $data);

        return self::$zoomInstance->updateMeeting($zoom_id, $meetingData);
    }

    public static function addRegistrant(int $meetingId, $user): array
    {
        self::init();

        $payload = [
            'email' => $user->email,
            'first_name' => $user->name,
            'last_name' => '.', // Zoom بيطلب الاتنين
        ];

        return self::$zoomInstance->addMeetingRegistrant($meetingId, $payload);
    }
}
