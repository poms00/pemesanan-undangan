<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function login(array $data): void
    {
        // Proses autentikasi
        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], true)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Regenerasi session setelah login
        session()->regenerate();
    }
}
