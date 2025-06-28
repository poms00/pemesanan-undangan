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

            // Referensi ke pemesanan
            $table->foreignId('pemesanan_id')->nullable()->constrained('pemesanans')->onDelete('cascade');

            // Midtrans identifiers
            $table->string('order_id')->unique(); // e.g. INV-20240619001
            $table->string('transaction_id')->nullable()->index(); // Midtrans transaction_id
            $table->string('snap_token')->nullable(); // For embedded Snap

            // Jenis dan detail pembayaran
            $table->string('payment_type')->nullable()->index(); // e.g. bank_transfer, gopay, qris
            $table->string('payment_code')->nullable(); // e.g. VA number, QR code
            $table->string('payment_channel')->nullable(); // e.g. bca, bni, mandiri, gopay

            // Nominal & currency - menggunakan string sesuai model
            $table->string('gross_amount'); // Disimpan sebagai string untuk kompatibilitas
            $table->string('currency', 3)->default('IDR');

            // Status transaksi dari Midtrans
            $table->enum('transaction_status', [
                'pending',
                'settlement',
                'capture',
                'deny',
                'cancel',
                'expire',
                'failure',
                'refund',
                'partial_refund'
            ])->nullable()->index();

            $table->enum('fraud_status', [
                'accept',
                'deny',
                'challenge'
            ])->nullable();

            $table->string('status_code', 10)->nullable(); // e.g. 201, 200, 407
            $table->text('status_message')->nullable(); // e.g. "Success, transaction is found"

            // Timestamps - sesuai dengan model cast
            $table->timestamp('transaction_time')->nullable(); // waktu transaksi dibuat
            $table->timestamp('settlement_time')->nullable(); // waktu pembayaran sukses
            $table->timestamp('expiry_time')->nullable(); // waktu kedaluwarsa

            // Log respons dari Midtrans - akan di-cast ke array
            $table->json('snap_response')->nullable(); // saat generate snap token
            $table->json('notification_response')->nullable(); // webhook callback dari Midtrans

            $table->timestamps();

            // Indexes untuk performance berdasarkan scope dan method di model
            $table->index(['transaction_status', 'created_at']);
            $table->index(['payment_type', 'transaction_status']);
            $table->index(['transaction_status', 'fraud_status']); // untuk scope success dan capture
            $table->index('expiry_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
