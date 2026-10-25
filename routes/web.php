<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\ReadingsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dispositivos', [DevicesController::class, 'index'])->name('devices');
    Route::post('/dispositivos', [DevicesController::class, 'store'])->name('devices.store');
    Route::put('/dispositivos/{device}', [DevicesController::class, 'update'])->name('devices.update');
    Route::delete('/dispositivos/{device}', [DevicesController::class, 'destroy'])->name('devices.destroy');
    Route::get('/leituras', [ReadingsController::class, 'index'])->name('readings');
});
