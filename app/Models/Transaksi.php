<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'order_id',
        'transaction_id',
        'snap_token',
        'payment_type',
        'payment_code',
        'payment_channel',
        'gross_amount',
        'currency',
        'transaction_status',
        'fraud_status',
        'status_code',
        'status_message',
        'transaction_time',
        'settlement_time',
        'expiry_time',
        'snap_response',
        'notification_response'
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
        'expiry_time' => 'datetime',
        'snap_response' => 'array',
        'notification_response' => 'array',
    ];

    protected $table = 'transaksis'; // Ubah ke 'transaksi' jika rename tabel

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class);
    }

    // Scope status
    public function scopeSettlement($query)
    {
        return $query->where('transaction_status', 'settlement');
    }

    public function scopePending($query)
    {
        return $query->where('transaction_status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->whereIn('transaction_status', ['cancel', 'deny', 'expire']);
    }

    // Status check
    public function isSettlement(): bool
    {
        return $this->transaction_status === 'settlement';
    }

    public function isPending(): bool
    {
        return $this->transaction_status === 'pending';
    }

    public function isFailed(): bool
    {
        return in_array($this->transaction_status, ['cancel', 'deny', 'expire']);
    }

    // Hitung total dari produk
    public function calculateGrossAmount(): float
    {
        if (!$this->pemesanan || !$this->pemesanan->detailPemesanan) {
            return 0;
        }

        $total = 0;

        foreach ($this->pemesanan->detailPemesanan as $detail) {
            if (!$detail->produk) continue;

            $produk = $detail->produk;
            $hargaSatuan = $produk->harga;
            $jumlah = $detail->jumlah ?? 1;

            if ($produk->diskon > 0) {
                $hargaSatuan -= ($hargaSatuan * $produk->diskon / 100);
            }

            $total += $hargaSatuan * $jumlah;
        }

        if ($this->pemesanan->diskon > 0) {
            $total -= ($total * $this->pemesanan->diskon / 100);
        }

        return round($total, 2);
    }

    public function setGrossAmountFromProduk(): void
    {
        $this->gross_amount = $this->calculateGrossAmount();
    }
}
