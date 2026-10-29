<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Auth;

Route::get('/trigger-order', function () {
    $order = (object) [
        'id' => rand(100, 999),
        'total' => 250000,
    ];

    event(new OrderPlaced($order, Auth::user()));

    return 'Event OrderPlaced berhasil dipicu! Silakan cek kembali tab dashboard Anda.';
})->middleware(['auth']);

require __DIR__.'/auth.php';
    