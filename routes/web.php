<?php

use App\Http\Controllers\AffichageDataController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MutuelleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('login');

// 🔹 Routes générales Mutuelles
Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');

// 🔹 Authentication Mutuelle
Route::get('/mutuelle/login', [MutuelleController::class, 'loginView'])->name('mutuelles.login');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');
Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::get('/mutuelle/logout', function () {
    Auth::guard('mutuelles')->logout();

    return redirect('/');
})->name('mutuelle.logout');

// 🔹 Authentication Client
Route::get('/client/login', [ClientController::class, 'showLoginForm'])->name('client.login');
Route::post('/client/login', [ClientController::class, 'login'])->name('client.login');
Route::post('/client/register', [ClientController::class, 'register'])->name('client.register');
Route::get('/client/logout', function () {
    Auth::guard('clients')->logout();

    return redirect('/');
})->name('client.logout');

// 🔹 Routes Mutuelle CRUD (Create / Read / Update / Delete)
Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::get('/mutuelles/{mutuelle}', [MutuelleController::class, 'show'])->name('mutuelles.show');
Route::get('/mutuelles/{mutuelle}/edit', [MutuelleController::class, 'edit'])->name('mutuelles.edit');

// Groupées sous auth:mutuelles
Route::middleware('auth:mutuelles')->group(function () {
    Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');
    Route::delete('/mutuelles/{mutuelle}', [MutuelleController::class, 'destroy'])->name('mutuelles.destroy');

    Route::get('/mutuelle/home', [MutuelleController::class, 'homeView'])->name('mutuelle.home');
    Route::get('/mutuelle/searchClient/{numero}', [MutuelleController::class, 'searchClientByNumeroSocial'])->name('mutuelle.searchClientByNumeroSocial');
    Route::get('/mutuelle/clients', [MutuelleController::class, 'listeClients'])->name('mutuelle.clients');
});

// 🔹 Routes Client Dashboard (Protegées par auth:clients)
Route::middleware('auth:clients')->group(function () {
    Route::get('/client/home', [ClientController::class, 'homeView'])->name('client.home');
    Route::get('/client/edit', [ClientController::class, 'editProfile'])->name('client.editProfile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.updateProfile');
    Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.deleteProfile');
});
