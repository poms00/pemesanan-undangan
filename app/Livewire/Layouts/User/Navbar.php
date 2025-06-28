<?php

namespace App\Livewire\Layouts\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriProduk;

class Navbar extends Component
{
    public $currentRoute = 'dashboard';
    public $mobileMenuOpen = false;
    public $userDropdownOpen = false;

    public function mount()
    {
        $this->currentRoute = request()->route()->getName() ?? 'dashboard';
    }

    public function setCurrentRoute($route)
    {
        $this->currentRoute = $route;
        $this->mobileMenuOpen = false;
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
        $kategoriProduks = KategoriProduk::orderBy('nama_kategori')->get();

        return view('livewire.layouts.user.navbar', [
            'kategoris' => KategoriProduk::all(),
        ]);
    }
}
