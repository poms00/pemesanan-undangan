<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $name, $email, $password, $role = 'user';
    public bool $showCreateModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,user',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'role.required' => 'Role wajib dipilih.',
    ];

    // ✅ Jalankan validasi per field saat diubah
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function openModal()
    {
        $this->showCreateModal = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password']);
        $this->role = 'user'; // Set default role
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);

            $this->resetForm();
            $this->showCreateModal = false;

            $this->dispatch('userCreated');
            $this->dispatch('toast:success', 'Berhasil Tambah data');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => 'Terjadi kesalahan saat menambahkan user.',
                'icon' => 'error'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.users.create')->layout('components.layouts.admin.admin');
    }
}
