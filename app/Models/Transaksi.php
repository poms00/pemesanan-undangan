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
        'gross_amount' => 'string', // Ubah dari decimal:2 ke string untuk kompatibilitas
        'transaction_time' => 'datetime',
        'settlement_time' => 'datetime',
        'expiry_time' => 'datetime',
        'snap_response' => 'array',
        'notification_response' => 'array',
    ];

    protected $table = 'transaksis';

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class);
    }

    // Scope untuk berbagai status
    public function scopeSettlement($query)
    {
        return $query->where('transaction_status', 'settlement');
    }

    public function scopeCapture($query)
    {
        return $query->where('transaction_status', 'capture')
            ->where('fraud_status', 'accept');
    }

    public function scopePending($query)
    {
        return $query->where('transaction_status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->whereIn('transaction_status', ['cancel', 'deny', 'expire']);
    }

    public function scopeSuccess($query)
    {
        return $query->where(function ($q) {
            $q->where('transaction_status', 'settlement')
                ->orWhere(function ($subQ) {
                    $subQ->where('transaction_status', 'capture')
                        ->where('fraud_status', 'accept');
                });
        });
    }

    public function scopeRefunded($query)
    {
        return $query->whereIn('transaction_status', ['refund', 'partial_refund']);
    }

    // Status check methods
    public function isSuccess(): bool
    {
        return $this->transaction_status === 'settlement' ||
            ($this->transaction_status === 'capture' && $this->fraud_status === 'accept');
    }

    public function isPending(): bool
    {
        return $this->transaction_status === 'pending';
    }

    public function isFailed(): bool
    {
        return in_array($this->transaction_status, ['cancel', 'deny', 'expire']);
    }

    public function isRefunded(): bool
    {
        return in_array($this->transaction_status, ['refund', 'partial_refund']);
    }

    public function isChallenged(): bool
    {
        return $this->transaction_status === 'capture' &&
            in_array($this->fraud_status, ['challenge', 'deny']);
    }

    // Payment type checks
    public function isCreditCard(): bool
    {
        return $this->payment_type === 'credit_card';
    }

    public function isBankTransfer(): bool
    {
        return in_array($this->payment_type, ['bank_transfer', 'echannel', 'permata']);
    }

    public function isEWallet(): bool
    {
        return in_array($this->payment_type, ['gopay', 'shopeepay', 'qris']);
    }

    public function isConvenienceStore(): bool
    {
        return in_array($this->payment_type, ['cstore', 'alfamart', 'indomaret']);
    }

    // Hitung total dari produk
    public function calculateGrossAmount(): string
    {
        if (!$this->pemesanan || !$this->pemesanan->detailPemesanan) {
            return '0.00';
        }

        $total = 0;

        foreach ($this->pemesanan->detailPemesanan as $detail) {
            if (!$detail->produk) continue;

            $produk = $detail->produk;
            $hargaSatuan = (float) $produk->harga;
            $jumlah = $detail->jumlah ?? 1;

            // Apply product discount
            if ($produk->diskon > 0) {
                $hargaSatuan -= ($hargaSatuan * $produk->diskon / 100);
            }

            $total += $hargaSatuan * $jumlah;
        }

        // Apply order discount
        if ($this->pemesanan && $this->pemesanan->diskon > 0) {
            $total -= ($total * $this->pemesanan->diskon / 100);
        }

        return number_format($total, 2, '.', '');
    }

    public function setGrossAmountFromProduk(): void
    {
        $this->gross_amount = $this->calculateGrossAmount();
    }

    // Helper method untuk mendapatkan gross amount sebagai float
    public function getGrossAmountAsFloat(): float
    {
        return (float) $this->gross_amount;
    }

    // Helper method untuk mendapatkan gross amount sebagai integer (dalam cents)
    public function getGrossAmountAsCents(): int
    {
        return (int) ($this->getGrossAmountAsFloat() * 100);
    }

    // Get formatted payment code berdasarkan payment type
    public function getFormattedPaymentCode(): ?string
    {
        if (empty($this->payment_code)) {
            return null;
        }

        switch ($this->payment_type) {
            case 'bank_transfer':
            case 'echannel':
                return 'Transfer Bank - ' . $this->payment_code;
            case 'cstore':
                return 'Convenience Store - ' . $this->payment_code;
            case 'alfamart':
                return 'Alfamart - ' . $this->payment_code;
            case 'indomaret':
                return 'Indomaret - ' . $this->payment_code;
            default:
                return $this->payment_code;
        }
    }

    // Get human readable status
    public function getStatusLabel(): string
    {
        switch ($this->transaction_status) {
            case 'settlement':
                return 'Berhasil';
            case 'capture':
                return $this->fraud_status === 'accept' ? 'Berhasil' : 'Perlu Review';
            case 'pending':
                return 'Menunggu Pembayaran';
            case 'deny':
                return 'Ditolak';
            case 'cancel':
                return 'Dibatalkan';
            case 'expire':
                return 'Kedaluwarsa';
            case 'refund':
                return 'Dikembalikan';
            case 'partial_refund':
                return 'Dikembalikan Sebagian';
            default:
                return ucfirst($this->transaction_status);
        }
    }

    // Get payment method name
    public function getPaymentMethodName(): string
    {
        switch ($this->payment_type) {
            case 'credit_card':
                return 'Kartu Kredit';
            case 'bank_transfer':
                return 'Transfer Bank';
            case 'echannel':
                return 'Mandiri Bill Payment';
            case 'permata':
                return 'Permata Virtual Account';
            case 'bca_va':
                return 'BCA Virtual Account';
            case 'bni_va':
                return 'BNI Virtual Account';
            case 'bri_va':
                return 'BRI Virtual Account';
            case 'gopay':
                return 'GoPay';
            case 'shopeepay':
                return 'ShopeePay';
            case 'qris':
                return 'QRIS';
            case 'cstore':
                return 'Convenience Store';
            case 'alfamart':
                return 'Alfamart';
            case 'indomaret':
                return 'Indomaret';
            default:
                return ucfirst(str_replace('_', ' ', $this->payment_type));
        }
    }
}
