<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MidtransController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans Webhook Received', [
            'order_id' => $request->input('order_id'),
            'transaction_status' => $request->input('transaction_status'),
            'signature_key' => $request->input('signature_key')
        ]);

        // Ambil data yang diperlukan untuk signature
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $serverKey = env('MIDTRANS_SERVER_KEY');

        // Validasi input yang diperlukan
        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::error('Missing required webhook data', [
                'order_id' => $orderId,
                'status_code' => $statusCode,
                'gross_amount' => $grossAmount,
                'signature_key' => $signatureKey ? 'present' : 'missing'
            ]);
            return response('Bad Request', 400);
        }

        // Validasi signature sesuai dokumentasi Midtrans
        if (!$this->verifySignature($orderId, $statusCode, $grossAmount, $signatureKey, $serverKey)) {
            Log::warning('Invalid signature', [
                'order_id' => $orderId,
                'received_signature' => $signatureKey
            ]);
            return response('Invalid signature', 403);
        }

        // Gunakan database transaction untuk konsistensi
        DB::beginTransaction();

        try {
            // Cari transaksi berdasarkan order_id
            $transaksi = Transaksi::where('order_id', $orderId)->first();

            if (!$transaksi) {
                Log::warning("Transaction not found for order_id: {$orderId}");
                DB::rollBack();
                return response('Transaction not found', 404);
            }

            // Cek apakah status sudah final, jangan overwrite
            if ($this->isFinalStatus($transaksi->transaction_status)) {
                $newStatus = $request->input('transaction_status');

                // Hanya izinkan perubahan status tertentu dari status final
                if (!$this->isValidStatusTransition($transaksi->transaction_status, $newStatus)) {
                    Log::info('Ignoring webhook - transaction already in final status', [
                        'order_id' => $orderId,
                        'current_status' => $transaksi->transaction_status,
                        'new_status' => $newStatus
                    ]);
                    DB::rollBack();
                    return response('Transaction already processed', 200);
                }
            }

            // Cek timestamp untuk mencegah webhook lama overwrite yang baru
            $transactionTime = $this->parseDateTime($request->input('transaction_time'));
            if ($transactionTime && $transaksi->transaction_time && $transactionTime < $transaksi->transaction_time) {
                Log::info('Ignoring older webhook notification', [
                    'order_id' => $orderId,
                    'current_time' => $transaksi->transaction_time,
                    'webhook_time' => $transactionTime
                ]);
                DB::rollBack();
                return response('Older notification ignored', 200);
            }

            // Simpan status lama untuk logging
            $oldStatus = $transaksi->transaction_status;

            // Update data transaksi dengan data dari notification
            $this->updateTransactionData($transaksi, $request);

            // Handle status transaksi berdasarkan transaction_status
            $this->handleTransactionStatus($transaksi, $request);

            DB::commit();

            Log::info("Transaction updated successfully", [
                'order_id' => $orderId,
                'old_status' => $oldStatus,
                'new_status' => $transaksi->transaction_status,
                'payment_type' => $transaksi->payment_type
            ]);

            return response('OK', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing webhook', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response('Internal Server Error', 500);
        }
    }

    /**
     * Verifikasi signature sesuai dokumentasi Midtrans
     */
    private function verifySignature($orderId, $statusCode, $grossAmount, $signatureKey, $serverKey)
    {
        // Pastikan format gross_amount konsisten (tanpa format ribuan)
        $grossAmount = number_format((float) $grossAmount, 2, '.', '');

        // Gunakan string mentah dari Midtrans
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
     * Cek apakah status transaksi sudah final
     */
    private function isFinalStatus($status)
    {
        $finalStatuses = [
            'settlement',
            'capture', // jika fraud_status = accept
            'deny',
            'cancel',
            'expire',
            'refund',
            'partial_refund'
        ];

        return in_array($status, $finalStatuses);
    }

    /**
     * Validasi transisi status yang diizinkan
     */
    private function isValidStatusTransition($currentStatus, $newStatus)
    {
        // Status transitions yang diizinkan dari status final
        $allowedTransitions = [
            'settlement' => ['refund', 'partial_refund'],
            'capture' => ['refund', 'partial_refund', 'settlement'],
            'deny' => [], // Tidak ada transisi yang diizinkan
            'cancel' => [], // Tidak ada transisi yang diizinkan
            'expire' => [], // Tidak ada transisi yang diizinkan
            'refund' => ['partial_refund'], // Bisa jadi partial refund
            'partial_refund' => ['refund'] // Bisa jadi full refund
        ];

        if (!isset($allowedTransitions[$currentStatus])) {
            return true; // Jika status tidak final, izinkan semua transisi
        }

        return in_array($newStatus, $allowedTransitions[$currentStatus]);
    }

    /**
     * Update data transaksi dengan data dari notification
     */
    private function updateTransactionData(Transaksi $transaksi, Request $request)
    {
        // Format gross_amount sebagai string dengan 2 decimal places
        $grossAmount = number_format((float) $request->input('gross_amount'), 2, '.', '');

        // Hanya update field yang tidak null atau berbeda
        $updateData = [];

        if ($request->has('transaction_id') && $request->input('transaction_id')) {
            $updateData['transaction_id'] = $request->input('transaction_id');
        }

        if ($request->has('transaction_status')) {
            $updateData['transaction_status'] = $request->input('transaction_status');
        }

        if ($request->has('fraud_status')) {
            $updateData['fraud_status'] = $request->input('fraud_status');
        }

        if ($request->has('status_code')) {
            $updateData['status_code'] = $request->input('status_code');
        }

        if ($request->has('status_message')) {
            $updateData['status_message'] = $request->input('status_message');
        }

        if ($request->has('payment_type')) {
            $updateData['payment_type'] = $request->input('payment_type');
        }

        // Handle payment code dari berbagai sumber
        $paymentCode = $request->input('payment_code') ??
            $request->input('biller_code') ??
            $request->input('bill_key');
        if ($paymentCode) {
            $updateData['payment_code'] = $paymentCode;
        }

        $updateData['gross_amount'] = $grossAmount;
        $updateData['currency'] = $request->input('currency', 'IDR');

        // Parse datetime fields
        if ($request->has('transaction_time')) {
            $updateData['transaction_time'] = $this->parseDateTime($request->input('transaction_time'));
        }

        if ($request->has('settlement_time')) {
            $updateData['settlement_time'] = $this->parseDateTime($request->input('settlement_time'));
        }

        if ($request->has('expiry_time')) {
            $updateData['expiry_time'] = $this->parseDateTime($request->input('expiry_time'));
        }

        // Simpan raw notification response
        $updateData['notification_response'] = $request->all();
        $updateData['updated_at'] = now();

        $transaksi->update($updateData);
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
                Log::warning("Unknown transaction status: {$transactionStatus}", [
                    'order_id' => $transaksi->order_id
                ]);
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
        // Hanya update jika belum dalam status success
        if ($transaksi->pemesanan && !in_array($transaksi->pemesanan->status, ['paid', 'completed'])) {
            $transaksi->pemesanan->update([
                'status' => 'paid',
                'paid_at' => now()
            ]);

            Log::info("Payment successful and order updated", [
                'order_id' => $transaksi->order_id,
                'pemesanan_id' => $transaksi->pemesanan->id
            ]);
        }

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
        // Hanya update jika belum pending
        if ($transaksi->pemesanan && $transaksi->pemesanan->status !== 'pending_payment') {
            $transaksi->pemesanan->update([
                'status' => 'pending_payment'
            ]);
        }

        Log::info("Payment pending for order: {$transaksi->order_id}");
    }

    /**
     * Handle payment challenge (fraud detection)
     */
    private function onPaymentChallenge(Transaksi $transaksi)
    {
        if ($transaksi->pemesanan) {
            $transaksi->pemesanan->update([
                'status' => 'payment_review'
            ]);
        }

        Log::warning("Payment challenged for order: {$transaksi->order_id}");
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
