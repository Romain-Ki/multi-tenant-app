<?php

use App\Http\Controllers\MutuelleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AffichageDataController;
use Illuminate\Support\Facades\Route;

Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');

Route::post('/mutuelles', [MutuelleController::class, 'store'])->name('mutuelles.store');

Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');


Route::delete('/mutuelles/{mutuelle}', [MutuelleController::class, 'destroy'])->name('mutuelles.destroy');
