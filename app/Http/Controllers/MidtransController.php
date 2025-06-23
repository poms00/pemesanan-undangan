<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans Webhook Received', $request->all());

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $signatureKey = $request->input('signature_key');

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $input = $orderId . $transactionStatus . $fraudStatus . $serverKey;
        $computedSignature = hash('sha512', $input);

        if ($signatureKey !== $computedSignature) {
            Log::warning('Invalid signature on Midtrans webhook', $request->all());
            return response('Invalid signature', 403);
        }

        // Cari transaksi berdasarkan order_id
        $transaksi = Transaksi::where('order_id', $orderId)->first();

        // Kalau belum ada, buat baru (optional, tergantung alur bisnismu)
        if (!$transaksi) {
            $transaksi = new Transaksi();
            $transaksi->order_id = $orderId;
            // Bisa juga isi kolom lain yang wajib di sini
        }

        // Update field dari webhook
        $transaksi->transaction_status = $transactionStatus;
        $transaksi->fraud_status = $fraudStatus;
        $transaksi->status_code = $request->input('status_code');
        $transaksi->status_message = $request->input('status_message');
        $transaksi->transaction_time = $request->input('transaction_time');
        $transaksi->settlement_time = $request->input('settlement_time');
        $transaksi->expiry_time = $request->input('expiry_time');
        $transaksi->payment_type = $request->input('payment_type');
        $transaksi->payment_code = $request->input('payment_code');
        $transaksi->payment_channel = $request->input('payment_channel');
        $transaksi->gross_amount = $request->input('gross_amount');
        $transaksi->snap_token = $request->input('snap_token');
        $transaksi->snap_response = $request->input(); // bisa simpan keseluruhan request sebagai array jika perlu
        $transaksi->notification_response = $request->all();

        // Simpan data transaksi
        $transaksi->save();

        Log::info("Transaksi updated: {$orderId}, status: {$transactionStatus}");

        return response('OK', 200);
    }
}
