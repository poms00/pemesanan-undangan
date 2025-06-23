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
    public $perPage = 5; // <--- ini menentukan jumlah data per halaman
    protected $listeners = [
        'produksUpdated' => 'handleproduksUpdated',
        'produksCreated' => 'handleproduksCreated',
    ];

    // Reset pagination setiap kali search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function handleproduksCreated()
    {
        $total = Produk::count();
        $lastPage = (int) ceil($total / $this->perPage);
        $this->gotoPage($lastPage); // langsung ke halaman terakhir
    }


    public function handleproduksUpdated($produksId)
    {
        // Cari posisi user dengan id $userId berdasarkan urutan id ascending
        $position = Produk::where('id', '<=', $produksId)->count();

        // Hitung halaman user tersebut
        $page = (int) ceil($position / $this->perPage);

        // Arahkan ke halaman tersebut
        $this->gotoPage($page);
    }

    public $produkidBeingDeleted; // tetap simpan ID

    public function confirmDelete($id)
    {
        $this->produkidBeingDeleted = $id;
    }


    public function delete()
    {
        produk::findOrFail($this->produkidBeingDeleted)->delete();
        $this->dispatch('userDeleted');
        // Trigger SweetAlert
        $this->dispatch('toast:success', 'Berhasil Hapus data');
    }


    public function render()
    {
        $produks = Produk::with('kategori')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', '%' . $this->search . '%'))
            ->orderBy('id', 'asc') // urutkan dari ID kecil
            ->paginate($this->perPage);


        return view('livewire.admin.produks.produks-table', [
            'produks' => $produks
        ])->layout('components.layouts.admin.admin');
    }
}