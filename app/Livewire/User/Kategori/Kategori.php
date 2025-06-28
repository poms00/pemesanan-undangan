<?php

namespace App\Livewire\User\Kategori;

use Livewire\Component;
use App\Models\Produk;
use App\Models\KategoriProduk;

class Kategori extends Component
{
    public $kategoriId = 'all'; // Default: semua kategori
    public $search = '';

    public function mount($kategoriId = 'all')
    {
        $this->kategoriId = $kategoriId;
    }

    public function setFilterKategori($kategoriId)
    {
        $this->kategoriId = $kategoriId;
    }

    public function render()
    {
        $query = Produk::with('kategori')
            ->where('status', 'aktif');

        // Filter kategori jika bukan 'all'
        if ($this->kategoriId !== 'all') {
            $query->where('kategori_id', $this->kategoriId);
        }

        // Filter berdasarkan pencarian nama
        if (!empty($this->search)) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }

        return view('livewire.user.kategori.kategori', [
            'produkList'    => $query->get(),
            'kategoriList'  => KategoriProduk::all(),
            'selectedKategoriId' => $this->kategoriId,
        ])->layout('livewire.layouts.user.user-layout');
    }
}
