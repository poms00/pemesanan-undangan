<?php

namespace App\Livewire\Admin\Produks;

use Livewire\Component;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\WithPagination;

class ProduksTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    public $produkidBeingDeleted; // ID produk yang akan dihapus
    public $namaProdukBeingDeleted; // Nama produk yang akan dihapus

    protected $listeners = [
        'produksUpdated' => 'handleproduksUpdated',
        'produksCreated' => 'handleproduksCreated',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function handleproduksCreated()
    {
        $total = Produk::count();
        $lastPage = (int) ceil($total / $this->perPage);
        $this->gotoPage($lastPage);
    }

    public function handleproduksUpdated($produksId)
    {
        $position = Produk::where('id', '<=', $produksId)->count();
        $page = (int) ceil($position / $this->perPage);
        $this->gotoPage($page);
    }

    public function confirmDelete($id)
    {
        $this->produkidBeingDeleted = $id;

        $produk = Produk::find($id);
        $this->namaProdukBeingDeleted = $produk ? $produk->nama : 'produk';

        $this->dispatch('openDeleteModal');
    }

    public function delete()
    {
        Produk::findOrFail($this->produkidBeingDeleted)->delete();
        $this->dispatch('produkDeleted');
        $this->dispatch('toast:success', 'Berhasil Hapus data');

        // Kosongkan nilai setelah penghapusan
        $this->produkidBeingDeleted = null;
        $this->namaProdukBeingDeleted = null;
    }

    public function render()
    {
        $produks = Produk::with('kategori')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.produks.produks-table', [
            'produks' => $produks
        ])->layout('livewire.layouts.admin.admin');
    }
}
