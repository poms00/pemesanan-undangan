<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Kategori\KategoriTemplate;
use App\Livewire\Admin\Users\UserTable as Users;
use App\Livewire\Admin\Produks\ProduksTable as Produks;
use App\Livewire\Admin\Produks\Detail as Detail;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/users', Users::class)->name('users.user-table');
        Route::prefix('produks')->name('produks.')->group(function () {
            Route::get('/', Produks::class)->name('produks-table'); // admin.produks.produks-table
            Route::get('/{produkId}', Detail::class)->name('detail'); // admin.produks.detail
        });
    Route::get('/kategori', KategoriTemplate::class)->name('kategori.kategori-template');
});
