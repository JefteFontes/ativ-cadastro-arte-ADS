<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtController;

Route::get('/', [AuthController::class, 'ShowLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/feed', [ArtController::class, 'index'])->name('arts.index');
Route::post('/art/store', [ArtController::class, 'store'])->name('arts.store');
Route::put('/art/{id}', [ArtController::class, 'update'])->name('arts.update');
Route::delete('/art/{id}', [ArtController::class, 'destroy'])->name('arts.destroy'); 