<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $userId, $name, $email, $role, $password;

    // Validasi rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$this->userId}",
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:8',
        ];
    }

    // Custom pesan error
    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'role.required' => 'Role wajib dipilih.',
        'password.min' => 'Password minimal 8 karakter.',
    ];

    // Untuk real-time validation saat input berubah
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    // Event listener dari luar (biasanya tombol Edit ditekan)
    #[On('edit')]
    public function edit($id)
    {
        $this->reset(['userId', 'name', 'email', 'role', 'password']);

        $user = User::select('id', 'name', 'email', 'role')->findOrFail($id);
        $this->userId = $user->id;
        $this->name   = $user->name;
        $this->email  = $user->email;
        $this->role   = $user->role;
        $this->password = '';

        // Buka modal via JS listener
        $this->dispatch('EdituserModal');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password']);
        $this->role = 'user';
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;

        if (!empty($this->password)) {
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $this->resetValidation();

        // Notify komponen tabel user
        $this->dispatch('userUpdated', $this->userId);

        // Tampilkan notifikasi sukses
        $this->dispatch('toast:success', 'Berhasil Update data');
    }

    public function render()
    {
        return view('livewire.admin.users.edit')
            ->layout('components.layouts.admin.admin');
    }
}
