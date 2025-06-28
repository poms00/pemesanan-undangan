<?php

namespace App\Livewire\Admin\Kategori;

use Livewire\Component;
use App\Models\KategoriProduk;

class Create extends Component
{
    public $nama_kategori;

    protected function rules()
    {
        return [
            'nama_kategori' => 'required|string|min:3|unique:kategori_produks,nama_kategori',
        ];
    }

    protected $messages = [
        'nama_kategori.required' => 'Nama kategori wajib diisi.',
        'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
        'nama_kategori.unique' => 'Nama kategori sudah terdaftar.',
    ];

    // Validasi otomatis saat field berubah
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    


    public function resetForm()
    {
        $this->reset(['nama_kategori']);
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        try {
            KategoriProduk::create([
                'nama_kategori' => $this->nama_kategori,
            ]);

            $this->resetForm();

            $this->dispatch('kategoriCreated'); // Bisa digunakan untuk refresh tabel luar
            $this->dispatch('toast:success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Gagal!',
                'text' => 'Terjadi kesalahan saat menyimpan data kategori.',
                'icon' => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.kategori.create')
            ->layout('livewire.layouts.admin.admin');
    }
}
