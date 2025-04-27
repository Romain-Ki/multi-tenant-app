<?php

use App\Http\Controllers\MutuelleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AffichageDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');

Route::middleware('auth:mutuelles')->group(function () {
    Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');
    Route::delete('/mutuelles/{mutuelle}', [MutuelleController::class, 'destroy'])->name('mutuelles.destroy');
});

Route::middleware('auth:clients')->group(function () {
//    Route::get('/client/profile/edit', [ClientController::class, 'editProfile'])->name('client.editProfile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.updateProfile');
    Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.deleteProfile');
});





