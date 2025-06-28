<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\KategoriProduk;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;


class KategoriTemplate extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $kategoriIdBeingDeleted, $nama_kategoriBeingDeleted;

    protected $listeners = [
        'kategoriCreated' => 'handleKategoriCreated',
        'kategoriUpdated' => 'handleKategoriUpdated',
    ];

    // Reset ke halaman 1 saat search berubah
    public function updatingSearch()
    {
        $this->resetPage(); // ✅ saat search diubah, kembali ke halaman 1
    }

    public function updatedPerPage()
    {
        $this->resetPage(); // ✅ saat jumlah item per halaman diubah, kembali ke halaman 1
    }

    public function resetNamaKategori()
    {
        $this->nama_kategoriBeingDeleted = null;
    }

    public function handleKategoriCreated()
    {
        $total = KategoriProduk::count();
        $lastPage = (int) ceil($total / $this->perPage);
        $this->gotoPage($lastPage);
    }

    public function handleKategoriUpdated($kategoriId)
    {
        $position = KategoriProduk::where('id', '<=', $kategoriId)->count();
        $page = (int) ceil($position / $this->perPage);
        $this->gotoPage($page);
    }

    public function confirmDelete($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $this->kategoriIdBeingDeleted = $id;
        $this->nama_kategoriBeingDeleted = $kategori->nama_kategori;

        $this->dispatch('openDeleteModal');
    }

    public function delete()
    {
        if ($this->kategoriIdBeingDeleted) {
            try {
                $kategori = KategoriProduk::findOrFail($this->kategoriIdBeingDeleted);

                // Coba hapus kategori
                $kategori->delete();

                // Reset data modal
                $this->reset(['kategoriIdBeingDeleted', 'nama_kategoriBeingDeleted']);

                // Emit event untuk tutup modal dan refresh data
                $this->dispatch('kategoriDeleted');
                $this->dispatch('toast:success', 'Kategori berhasil dihapus.');
            } catch (QueryException $e) {
                $this->dispatch('kategoriDeleted');
                if ($e->getCode() === '23000') {
                    // Constraint FK gagal (kategori masih dipakai produk)
                    $this->dispatch('toast:info', 'Kategori masih digunakan oleh produk.');
                } else {
                    // Error lain
                    $this->dispatch('toast:error', 'Terjadi kesalahan saat menghapus kategori');
                }
            }
        }
    }


    public function render()
    {
        $kategoris = KategoriProduk::query()
            ->when($this->search, function ($query) {
                $query->where('nama_kategori', 'like', '%' . $this->search . '%')
                    ->orWhereDate('created_at', $this->search);
            })
            ->orderBy('id', 'asc') // ✅ urut dari ID terkecil
            ->paginate($this->perPage);

        return view('livewire.admin.kategori.kategori-template', [
            'kategoris' => $kategoris,
        ])->layout('livewire.layouts.admin.admin');
    }
}
