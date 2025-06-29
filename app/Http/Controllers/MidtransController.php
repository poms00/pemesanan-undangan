<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans Webhook Received', ['data' => $request->all()]);

        // Ambil data yang diperlukan untuk signature
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $serverKey = env('MIDTRANS_SERVER_KEY');

        // Validasi signature sesuai dokumentasi Midtrans
        if (!$this->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey, $serverKey)) {
            Log::warning('Invalid signature', [
                'order_id' => $orderId,
                'received_signature' => $signatureKey
            ]);
            return response('Invalid signature', 403);
        }

        // Cari atau buat transaksi baru
        $transaksi = Transaksi::where('order_id', $orderId)->first();

        if (!$transaksi) {
            Log::warning("Transaction not found for order_id: {$orderId}");
            return response('Transaction not found', 404);
        }

        // Update data transaksi dengan data dari notification
        $this->updateTransactionData($transaksi, $request);

        // Handle status transaksi berdasarkan transaction_status
        $this->handleTransactionStatus($transaksi, $request);

        Log::info("Transaction updated successfully", [
            'order_id' => $orderId,
            'transaction_status' => $transaksi->transaction_status,
            'payment_type' => $transaksi->payment_type
        ]);

        return response('OK', 200);
    }

    /**
     * Verifikasi signature sesuai dokumentasi Midtrans
     */
    private function verifySignature($orderId, $statusCode, $grossAmount, $signatureKey, $serverKey)
    {
        // Gunakan string mentah dari Midtrans (tanpa format ulang)
        $input = $orderId . $statusCode . $grossAmount . $serverKey;
        $computedSignature = hash('sha512', $input);

        Log::debug('Signature Verification', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'input_string' => $input,
            'computed_signature' => $computedSignature,
            'received_signature' => $signatureKey,
            'match' => hash_equals($computedSignature, $signatureKey)
        ]);

        return hash_equals($computedSignature, $signatureKey);
    }


    /**
     * Update data transaksi dengan data dari notification
     */
    private function updateTransactionData(Transaksi $transaksi, Request $request)
    {
        // Format gross_amount sebagai string dengan 2 decimal places
        $grossAmount = number_format((float) $request->input('gross_amount'), 2, '.', '');

        $transaksi->update([
            'transaction_id' => $request->input('transaction_id'),
            'transaction_status' => $request->input('transaction_status'),
            'fraud_status' => $request->input('fraud_status'),
            'status_code' => $request->input('status_code'),
            'status_message' => $request->input('status_message'),
            'payment_type' => $request->input('payment_type'),
            'payment_code' => $request->input('payment_code') ?? $request->input('biller_code') ?? $request->input('bill_key'),
            'gross_amount' => $grossAmount,
            'currency' => $request->input('currency', 'IDR'),
            'transaction_time' => $this->parseDateTime($request->input('transaction_time')),
            'settlement_time' => $this->parseDateTime($request->input('settlement_time')),
            'expiry_time' => $this->parseDateTime($request->input('expiry_time')),
            'notification_response' => $request->all(),
        ]);
    }

    /**
     * Handle status transaksi berdasarkan transaction_status
     */
    private function handleTransactionStatus(Transaksi $transaksi, Request $request)
    {
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus == 'accept') {
                    // Payment sukses
                    $this->onPaymentSuccess($transaksi);
                } else {
                    // Payment di-challenge, perlu review manual
                    $this->onPaymentChallenge($transaksi);
                }
                break;

            case 'settlement':
                // Payment berhasil di-settle
                $this->onPaymentSuccess($transaksi);
                break;

            case 'pending':
                // Payment pending, tunggu customer melakukan pembayaran
                $this->onPaymentPending($transaksi);
                break;

            case 'deny':
                // Payment ditolak oleh sistem
                $this->onPaymentDenied($transaksi);
                break;

            case 'cancel':
            case 'expire':
                // Payment dibatalkan atau expired
                $this->onPaymentCancelled($transaksi);
                break;

            case 'refund':
            case 'partial_refund':
                // Payment di-refund
                $this->onPaymentRefunded($transaksi);
                break;

            default:
                Log::warning("Unknown transaction status: {$transactionStatus}");
                break;
        }
    }

    /**
     * Parse datetime string ke Carbon instance
     */
    private function parseDateTime($datetime)
    {
        if (empty($datetime)) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($datetime);
        } catch (\Exception $e) {
            Log::warning("Failed to parse datetime: {$datetime}", ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Handle payment success
     */
    private function onPaymentSuccess(Transaksi $transaksi)
    {
        // Update status pemesanan jika ada
        if ($transaksi->pemesanan) {
            $transaksi->pemesanan->update([
                'status' => 'paid' // atau status yang sesuai dengan sistem Anda
            ]);
        }

        Log::info("Payment successful for order: {$transaksi->order_id}");

        // Tambahkan logic bisnis lainnya seperti:
        // - Kirim email konfirmasi
        // - Update inventory
        // - Trigger fulfillment process
    }

    /**
     * Handle payment pending
     */
    private function onPaymentPending(Transaksi $transaksi)
    {
        Log::info("Payment pending for order: {$transaksi->order_id}");

        // Tambahkan logic untuk pending payment seperti:
        // - Kirim reminder email
        // - Update status pemesanan
    }

    /**
     * Handle payment challenge (fraud detection)
     */
    private function onPaymentChallenge(Transaksi $transaksi)
    {
        Log::warning("Payment challenged for order: {$transaksi->order_id}");

        // Tambahkan logic untuk challenged payment seperti:
        // - Notifikasi admin untuk review manual
        // - Hold pemesanan
    }

    /**
     * Handle payment denied
     */
    private function onPaymentDenied(Transaksi $transaksi)
    {
        if ($transaksi->pemesanan) {
            $transaksi->pemesanan->update([
                'status' => 'payment_failed'
            ]);
        }

        Log::info("Payment denied for order: {$transaksi->order_id}");
    }

    /**
     * Handle payment cancelled/expired
     */
    private function onPaymentCancelled(Transaksi $transaksi)
    {
        if ($transaksi->pemesanan) {
            $transaksi->pemesanan->update([
                'status' => 'cancelled'
            ]);
        }

        Log::info("Payment cancelled/expired for order: {$transaksi->order_id}");
    }

    /**
     * Handle payment refunded
     */
    private function onPaymentRefunded(Transaksi $transaksi)
    {
        if ($transaksi->pemesanan) {
            $transaksi->pemesanan->update([
                'status' => 'refunded'
            ]);
        }

        Log::info("Payment refunded for order: {$transaksi->order_id}");
    }
}
