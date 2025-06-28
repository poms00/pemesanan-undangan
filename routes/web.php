<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransController;



Route::view('/', 'welcome');

Route::get('/login', function () {
    return view('auth.login');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('/midtrans/callback', [MidtransController::class, 'handle']);