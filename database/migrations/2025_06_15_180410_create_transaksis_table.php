<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Referensi internal (optional)
            $table->foreignId('pemesanan_id')->nullable()->constrained('pemesanans')->onDelete('cascade');

            // Midtrans identifiers
            $table->string('order_id')->unique(); // e.g. INV-20240619001
            $table->string('transaction_id')->nullable(); // Midtrans transaction_id
            $table->string('snap_token')->nullable(); // For embedded Snap

            // Jenis dan detail pembayaran
            $table->string('payment_type')->nullable(); // e.g. bank_transfer, gopay, qris
            $table->string('payment_code')->nullable(); // e.g. VA number, QR code (if available)
            $table->string('payment_channel')->nullable(); // e.g. bca, bni, mandiri, gopay

            // Nominal & currency
            $table->decimal('gross_amount', 15, 2); // e.g. 150000.00
            $table->string('currency')->default('IDR');

            // Status transaksi dari Midtrans
            $table->string('transaction_status')->nullable(); // pending, settlement, cancel, expire, deny
            $table->string('fraud_status')->nullable(); // accept, challenge, deny
            $table->string('status_code')->nullable(); // e.g. 201, 200, 407
            $table->string('status_message')->nullable(); // e.g. "Success, transaction is found"

            // Timestamps
            $table->timestamp('transaction_time')->nullable(); // waktu transaksi dibuat
            $table->timestamp('settlement_time')->nullable(); // waktu pembayaran sukses
            $table->timestamp('expiry_time')->nullable(); // waktu kedaluwarsa

            // Log respons dari Midtrans
            $table->json('snap_response')->nullable(); // saat generate snap token
            $table->json('notification_response')->nullable(); // webhook callback dari Midtrans

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
