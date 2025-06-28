<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori_id',
        'harga',
        'diskon',
        'thumbnail',
        'status',
        'template',        // File yang di-hash
        'nama_template',   // Nama asli file ZIP
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }
}
