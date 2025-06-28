<?php

namespace App\Livewire\User\Pesanan;

use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserPesanan extends Component
{
    public function render()
    {
        // Ambil pesanan milik user login, dengan relasi produk dan transaksi
        $pesanans = Pemesanan::with(['produk', 'transaksi'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.user.pesanan.user-pesanan', [
            'pesanans' => $pesanans
        ])->layout('livewire.layouts.user.user-layout');
    }
}
