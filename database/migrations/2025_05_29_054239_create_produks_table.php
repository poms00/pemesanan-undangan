<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('kategori_id');
            $table->decimal('harga', 10, 2);
            $table->unsignedTinyInteger('diskon')->nullable(); // Ubah dari decimal ke tinyint
            $table->string('thumbnail')->nullable(); // Ubah dari gambar1
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->string('template')->nullable(); // Tambahan untuk file ZIP opsional
            $table->timestamps();

            // Relasi ke kategori_produk
            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori_produks')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
