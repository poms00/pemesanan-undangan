<?php

namespace App\Livewire\User\Template;

use Livewire\Component;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;

class UserTemplate extends Component
{
    public $search = '';

    public function pilihProduk($produkId)
    {
        // Ambil produk
        $produk = Produk::find($produkId);
        if (!$produk) {
            $this->dispatch('toast:error', 'Produk tidak ditemukan.');
            return;
        }

        // Hitung total harga setelah diskon
        $totalHarga = $this->hitungTotal($produk);

        // Siapkan order_id
        $order_id = 'INV-' . now()->format('YmdHis') . '-' . rand(1000, 9999);


        // Buat Snap Token
        $midtransService = app(MidtransService::class);
        $snapTransaction = $midtransService->createSnapTransaction([
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => (int) $totalHarga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()?->name ?? 'User',
                'email' => Auth::user()?->email ?? 'noemail@example.com',
            ],
            'item_details' => [
                [
                    'id' => $produk->id,
                    'price' => (int) $totalHarga,
                    'quantity' => 1,
                    'name' => $produk->nama,
                ]
            ],
        ]);

        $snapToken = $snapTransaction->token ?? null;

        if (!$snapToken) {
            $this->dispatch('toast:error', 'Gagal membuat token pembayaran.');
            return;
        }

        // Simpan data ke session (bukan ke database)
        session()->put('checkout', [
            'produk_id'     => $produk->id,
            'nama_produk'   => $produk->nama,
            'harga'         => $totalHarga,
            'user_id'       => Auth::id(),
            'nama_pemesan'  => Auth::user()?->name ?? 'User',
            'email_pemesan' => Auth::user()?->email ?? 'noemail@example.com',
            'snap_token'    => $snapToken,
            'order_id'      => $order_id,
        ]);

        // Debug isi session
       // dd(session('checkout'));

        // Redirect ke halaman checkout
        return redirect()->route('user.checkout.user-order');
    }


    private function hitungTotal($produk)
    {
        $harga = $produk->harga ?? 0;
        $diskon = $produk->diskon ?? 0;
        $potongan = ($harga * $diskon) / 100;
        return max(0, $harga - $potongan);
    }


    public function render()
    {
        $produks = Produk::with('kategori')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'asc') // urutkan dari ID kecil
            ->get(); // ambil semua data tanpa pagination

        return view('livewire.user.template.user-template', [
            'produks' => $produks
        ])->layout('livewire.layouts.user.user-layout');
    }
}
