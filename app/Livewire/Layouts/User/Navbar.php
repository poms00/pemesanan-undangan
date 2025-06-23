<?php

namespace App\Livewire\Layouts\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $currentRoute = 'dashboard';
    public $mobileMenuOpen = false;
    public $userDropdownOpen = false;

    public function mount()
    {
        // Set current route based on current request
        $this->currentRoute = request()->route()->getName() ?? 'dashboard';
    }

    public function setCurrentRoute($route)
    {
        $this->currentRoute = $route;
        $this->mobileMenuOpen = false; // Close mobile menu when navigating
    }

    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    public function toggleUserDropdown()
    {
        $this->userDropdownOpen = !$this->userDropdownOpen;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.layouts.user.navbar');
    }
}
