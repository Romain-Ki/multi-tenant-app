<?php

use App\Http\Controllers\AffichageDataController;
use App\Http\Controllers\MutuelleController;
use App\Models\Mutuelles;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');

Route::middleware('auth')->get('/mutuelle/home', function () {
    return view('mutuelles.home');
})->name('mutuelles.home');

Route::view('/mutuelle/register', 'mutuelles.register');
Route::view('/mutuelle/login', 'mutuelles/login');

Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');
