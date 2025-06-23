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

        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $input = $orderId . $statusCode . $grossAmount . $serverKey;
        $computedSignature = hash('sha512', $input);

        if ($signatureKey !== $computedSignature) {
            Log::warning('Invalid signature', ['computed' => $computedSignature, 'received' => $signatureKey]);
            return response('Invalid signature', 403);
        }

        $transaksi = Transaksi::firstOrNew(['order_id' => $orderId]);

        $transaksi->fill([
            'transaction_status' => $request->input('transaction_status'),
            'fraud_status' => $request->input('fraud_status'),
            'status_code' => $statusCode,
            'status_message' => $request->input('status_message'),
            'transaction_time' => $request->input('transaction_time'),
            'settlement_time' => $request->input('settlement_time'),
            'expiry_time' => $request->input('expiry_time'),
            'payment_type' => $request->input('payment_type'),
            'payment_code' => $request->input('payment_code'),
            'payment_channel' => $request->input('payment_channel'),
            'gross_amount' => $grossAmount,
            'snap_token' => $request->input('snap_token'),
            'snap_response' => $request->input(),
            'notification_response' => $request->all(),
        ]);

        $transaksi->save();

        Log::info("Transaksi updated: {$orderId}, status: {$transaksi->transaction_status}");

        return response('OK', 200);
    }
}
