<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();

            // Relasi ke user yang memesan
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke produk (template)
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');

            // Data snapshot agar riwayat pemesanan tetap valid walau user/produk berubah
            $table->string('nama_pemesan');
            $table->string('email_pemesan');
            $table->string('nama_template');

            // Data undangan
            $table->string('nama_mempelai_pria')->nullable();
            $table->string('nama_mempelai_wanita')->nullable();
            $table->date('tanggal_acara')->nullable();
            $table->unsignedInteger('jumlah_tamu')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('nomor_telepon')->nullable();

            $table->enum('status_pemesanan', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->string('link_undangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
