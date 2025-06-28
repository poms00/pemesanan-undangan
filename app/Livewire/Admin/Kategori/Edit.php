<?php

namespace App\Livewire\Admin\Kategori;

use Livewire\Component;
use App\Models\KategoriProduk;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $kategoriId, $nama_kategori;

    #[On('edit')]
    public function edit($id)
    {
        $this->reset(['kategoriId', 'nama_kategori']);

        $kategori = KategoriProduk::select('id', 'nama_kategori')->findOrFail($id);
        $this->kategoriId = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;

        $this->dispatch('EditKategoriModal');
    }

    protected function rules()
    {
        return [
            'nama_kategori' => "required|string|min:3|unique:kategori_produks,nama_kategori,{$this->kategoriId}",
        ];
    }

    protected $messages = [
        'nama_kategori.required' => 'Nama kategori wajib diisi.',
        'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
        'nama_kategori.unique' => 'Nama kategori sudah terdaftar.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm()
    {
        $this->reset(['nama_kategori']);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $kategori = KategoriProduk::findOrFail($this->kategoriId);
        $kategori->nama_kategori = $this->nama_kategori;
        $kategori->save();

        $this->resetValidation();

        $this->dispatch('kategoriUpdated', $this->kategoriId);
        $this->dispatch('toast:success', 'Berhasil update kategori');
    }

    public function render()
    {
        return view('livewire.admin.kategori.edit')
            ->layout('livewire.layouts.admin.admin');
    }
}
