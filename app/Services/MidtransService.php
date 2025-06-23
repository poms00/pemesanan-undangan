<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Exception;

class MidtransService
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Tambahkan konfigurasi CURL opsional
        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ];
    }

    /**
     * Buat Snap Token dari parameter transaksi
     */
    public function createSnapToken(array $params): string
    {
        try {
            $transaction = Snap::createTransaction($params);
            return $transaction->token;
        } catch (Exception $e) {
            logger()->error('Midtrans Snap Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            throw new Exception('Gagal membuat Snap Token');
        }
    }

    /**
     * Kembalikan Snap response full (jika butuh lebih dari token)
     */
    public function createSnapTransaction(array $params): object
    {
        try {
            return Snap::createTransaction($params);
        } catch (Exception $e) {
            logger()->error('Midtrans Snap Error: ' . $e->getMessage());
            throw new Exception('Gagal membuat transaksi Midtrans');
        }
    }
}
