<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::$createUrlCallback = function ($notifiable) {
            // Genera la URL con los parámetros 'id' y 'hash'
            $url = 'http://localhost:4200/verify_email?id=' . $notifiable->getKey() . '&hash=' . sha1($notifiable->getEmailForVerification());
            return $url;
        };
    }



}
