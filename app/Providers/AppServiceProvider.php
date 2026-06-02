<?php

namespace App\Providers;

use App\Listeners\UpdateUserTimezone;
use App\Models\User;
use App\Support\DateTime\TimezoneService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TimezoneService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, UpdateUserTimezone::class);
        Gate::define('viewLogViewer', function (User $user) {
            return (auth()->check() && auth()->user()->email === 'superadmin@admin.com') || app()->environment('local');
        });

        Gate::define('viewPulse', function (User $user) {
            return (auth()->check() && auth()->user()->email === 'superadmin@admin.com') || app()->environment('local');
        });

        Storage::extend('bunny_stream', function ($app, $config) {
            return Storage::build([
                'driver' => 'local',
                'root' => storage_path('app/bunny_stream_dummy'),
            ]);
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject(__('lang.verify_email_address'))
                ->greeting(__('lang.reset_password_greeting', ['name' => $notifiable->name]))
                ->line(__('lang.click_the_button_below_to_verify_your_email_address'))
                ->action(__('lang.verify_email_address'), $url);
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false));

            return (new MailMessage)
                ->subject(__('lang.reset_password_subject'))
                ->greeting(__('lang.reset_password_greeting', ['name' => $notifiable->name]))
                ->line(__('lang.reset_password_line_1'))
                ->action(__('lang.reset_password_action'), $url)
                ->line(__('lang.reset_password_line_2', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(__('lang.reset_password_line_3'))
                ->salutation(__('lang.reset_password_salutation'));
        });
    }
}
