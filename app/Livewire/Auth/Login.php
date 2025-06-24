<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\LoginUser;
use App\Livewire\Forms\LoginForm;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function login(LoginUser $loginUser): void
    {
        $this->validate();

        $loginUser->login($this->form->all());

        $redirect = auth()->user()->role === 'admin'
            ? '/admin/dashboard'
            : '/user/dashboard';

        redirect()->intended($redirect);
    }



    public function render()
    {
        return view('livewire.auth.login');
    }
}
