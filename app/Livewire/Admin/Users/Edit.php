<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class Edit extends Component
{

    public $userId, $name, $email, $role, $password;
    

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

        // Dispatch event untuk JS buka modal
        $this->dispatch('EditModal');
    }



    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$this->userId}",
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:8',
        ]);

        $user = User::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;

        if ($this->password) {
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $this->resetValidation();
       

        $this->dispatch('userUpdated', $this->userId);// refresh data user

        // Trigger SweetAlert
        $this->dispatch('toast:success', 'Berhasil Update data');
    }



    public function render()
    {
        return view('livewire.admin.users.edit')->layout('components.layouts.admin.admin');
    }
}
