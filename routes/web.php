<?php

use Illuminate\Support\Facades\Route;



Route::view('/', 'welcome');

Route::get('/login', \App\Livewire\Auth\Login::class);

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

