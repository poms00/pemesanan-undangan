<?php

namespace App\Livewire\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUser
{
    public function register(array $data): void
    {
        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'user', // default role
        ]);
    }
}
