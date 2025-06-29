<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'nama_pemesan',
        'email_pemesan',
        'nama_template',
        'nama_mempelai_pria',
        'nama_mempelai_wanita',
        'tanggal_acara', 
        'jumlah_tamu',
        'lokasi',
        'nomor_telepon', 
        'status_pemesanan',
        'link_undangan',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke transaksi (jika 1 pemesanan = 1 transaksi)
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
