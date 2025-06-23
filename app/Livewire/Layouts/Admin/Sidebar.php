<?php

namespace App\Livewire\Layouts\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Sidebar extends Component
{

    public $activeMenu = '';

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function mount()
    {
        $routeName = Route::currentRouteName();

        if (str_starts_with($routeName, 'admin.produks.')) {
            $this->activeMenu = 'produks';
        } elseif ($routeName === 'admin.dashboard') {
            $this->activeMenu = 'dashboard';
        } elseif ($routeName === 'admin.users.user-table') {
            $this->activeMenu = 'users';
        } else {
            $this->activeMenu = '';
        }
    }


    public function render()
    {
        return view('livewire.layouts.admin.sidebar');
    }
}
