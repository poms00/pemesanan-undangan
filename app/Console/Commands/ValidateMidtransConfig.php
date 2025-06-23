<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Midtrans\Config;
use Midtrans\CoreApi;

class ValidateMidtransConfig extends Command
{
    protected $signature = 'midtrans:validate';
    protected $description = 'Validate Midtrans configuration';

    public function handle()
    {
        $this->info('🔍 Validating Midtrans Configuration...');
        $this->newLine();

        // 1. Cek konfigurasi di .env
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $clientKey = env('MIDTRANS_CLIENT_KEY');
        $isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        $this->table(['Config', 'Value', 'Status'], [
            ['MIDTRANS_SERVER_KEY', $serverKey ? substr($serverKey, 0, 15) . '...' : 'NOT SET', $serverKey ? '✅' : '❌'],
            ['MIDTRANS_CLIENT_KEY', $clientKey ? substr($clientKey, 0, 15) . '...' : 'NOT SET', $clientKey ? '✅' : '❌'],
            ['MIDTRANS_IS_PRODUCTION', $isProduction ? 'true' : 'false', '✅'],
        ]);

        if (!$serverKey || !$clientKey) {
            $this->error('❌ Midtrans configuration is incomplete!');
            $this->newLine();
            $this->info('Please add the following to your .env file:');
            $this->line('MIDTRANS_SERVER_KEY=your_server_key_here');
            $this->line('MIDTRANS_CLIENT_KEY=your_client_key_here');
            $this->line('MIDTRANS_IS_PRODUCTION=false');
            $this->newLine();
            $this->info('You can get your keys from: https://dashboard.midtrans.com/settings/config_info');
            return 1;
        }

        // 2. Test konfigurasi dengan Midtrans API
        try {
            Config::$serverKey = $serverKey;
            Config::$isProduction = $isProduction;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $this->info('🧪 Testing connection to Midtrans API...');

            // Test dengan mencoba mendapatkan status transaksi dummy
            $testOrderId = 'TEST-' . time();

            try {
                CoreApi::status($testOrderId);
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'Transaction doesn\'t exist') !== false) {
                    $this->info('✅ Connection to Midtrans API successful!');
                } else {
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            $this->error('❌ Failed to connect to Midtrans API: ' . $e->getMessage());
            return 1;
        }

        // 3. Cek konfigurasi Laravel
        $this->newLine();
        $this->info('🔧 Checking Laravel configuration...');

        $configServerKey = config('services.midtrans.server_key');
        $configClientKey = config('services.midtrans.client_key');

        if ($configServerKey && $configClientKey) {
            $this->info('✅ Laravel configuration is correct!');
        } else {
            $this->error('❌ Laravel configuration missing! Please check config/services.php');
            return 1;
        }

        $this->newLine();
        $this->info('🎉 All Midtrans configurations are valid!');
        $this->info('Environment: ' . ($isProduction ? 'PRODUCTION' : 'SANDBOX'));

        return 0;
    }
}
