<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;

class MidtransServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Config::$serverKey = config('SB-Mid-server-jvDnH7RQ8qASS3VvC6SUXu9v');
        Config::$clientKey = config('SB-Mid-client-JvdDVScz2YtBHZ31');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        // Untuk development/sandbox
        if (!config('midtrans.is_production')) {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ];
        }
    }

    public function register()
    {
        //
    }
}
