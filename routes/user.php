<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Template\UserTemplate;
use App\Livewire\User\Checkout\UserOrder;

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/template', UserTemplate::class)->name('template.user-template');
        Route::get('/checkout', UserOrder::class)->name('checkout.user-order');
});
