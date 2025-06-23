<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\RegisterUser;
use App\Livewire\Forms\RegisterForm;
use Livewire\Component;

class Register extends Component
{
    public RegisterForm $form; // gunakan Form Object

    public function register(RegisterUser $registerUser): void
    {
        $this->validate();

        $registerUser->register($this->form->all()); // kirim data dari Form Object

        redirect('/login'); // setelah register berhasil
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
