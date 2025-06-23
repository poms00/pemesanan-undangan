<?php

namespace App\Livewire\User\Checkout;

use Livewire\Component;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Log;

class UserOrder extends Component
{
    public $checkout, $produk;


    public $nama_mempelai_pria, $nama_mempelai_wanita, $tanggal_acara, $jumlah_tamu, $lokasi, $nomor_telepon;

    public $snapToken;


    public function mount()
    {
        $checkout = session('checkout');     // $this->order = Pemesanan::with('transaksi')->where('order_id', $orderId)->firstOrFail();
        if (!$checkout) {
            return redirect()->route('user.template.user-template')
                ->with('error', 'Silakan pilih produk terlebih dahulu.');
        }

        $this->checkout = $checkout;
        // Ambil dan simpan produk ke properti
        $this->produk = Produk::with('kategori')->find($checkout['produk_id']);
    }


    public function submitpemesanan()
    {
        $checkout = $this->checkout;

        // Validasi isi session
        if (empty($checkout['harga']) || empty($checkout['snap_token']) || empty($checkout['order_id'])) {
            $this->dispatch('toast:error', 'Data pembayaran tidak lengkap.');
            return;
        }

        $orderId = $checkout['order_id'];

        // ✅ CEK APAKAH ORDER_ID SUDAH ADA
        $existingTransaction = Transaksi::where('order_id', $orderId)->first();

        if ($existingTransaction) {
            // Jika transaksi sudah ada, redirect ke halaman pembayaran
            session()->forget('checkout');
            $this->dispatch('toast:info', 'Transaksi sudah dibuat sebelumnya.');
            return redirect()->route('payment.status', $existingTransaction->id);
        }

        // Ambil nilai dari session
        $total = $checkout['harga'];
        $snapToken = $checkout['snap_token'];

        try {
            // Simpan pemesanan
            $pemesanan = Pemesanan::create([
                'user_id'            => $checkout['user_id'],
                'produk_id'          => $checkout['produk_id'],
                'nama_pemesan'       => $checkout['nama_pemesan'],
                'email_pemesan'      => $checkout['email_pemesan'],
                'nama_template'      => $checkout['nama_produk'],
                'status_pemesanan'   => 'pending',
                'nama_mempelai_pria' => $this->nama_mempelai_pria,
                'nama_mempelai_wanita' => $this->nama_mempelai_wanita,
                'tanggal_acara'      => $this->tanggal_acara,
                'jumlah_tamu'        => $this->jumlah_tamu,
                'lokasi'             => $this->lokasi,
                'nomor_telepon'      => $this->nomor_telepon,
            ]);

            // Simpan transaksi
            Transaksi::create([
                'user_id'            => $checkout['user_id'],
                'produk_id'          => $checkout['produk_id'],
                'order_id'           => $orderId,
                'snap_token'         => $snapToken,
                'gross_amount'       => $total,
                'currency'           => 'IDR',
                'transaction_status' => 'pending',
                'transaction_time'   => now(),
                'expiry_time'        => now()->addHours(24),
                'snap_response'      => [],
                'pemesanan_id'       => $pemesanan->id,
            ]);

            // Hapus session setelah berhasil
            session()->forget('checkout');

            $this->dispatch('toast:success', 'Pemesanan berhasil dibuat!');
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Terjadi kesalahan saat menyimpan data.');
            Log::error('Error submitpemesanan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user.checkout.user-order', [
            'checkout' => $this->checkout,
        ])->layout('livewire.layouts.user.user-layout');
    }
}
