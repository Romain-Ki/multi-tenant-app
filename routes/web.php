<?php

use App\Http\Controllers\AffichageDataController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MutuelleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

// Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');

Route::middleware('auth:mutuelles')
    ->get('/mutuelle/home', [MutuelleController::class, 'homeView'])->name('mutuelle.home');
Route::get('/mutuelle/login', [MutuelleController::class, 'loginView'])->name('mutuelles.login');
Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');
Route::middleware('auth:mutuelles')
    ->get('/mutuelle/searchClient/{numero}', [MutuelleController::class, 'searchClientByNumeroSocial'])->name('mutuelle.searchClientByNumeroSocial');
Route::get('/mutuelle/logout', [MutuelleController::class, 'logout'])->name('mutuelle.logout');

Route::get('/client/login', [ClientController::class, 'showLoginForm'])->name('client.login');
Route::post('/client/login', [ClientController::class, 'login'])->name('client.login');
Route::get('/register', [ClientController::class, 'create'])->name('clients.register'); // formulaire
Route::post('/register', [ClientController::class, 'register'])->name('clients.store');
