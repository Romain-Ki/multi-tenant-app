<?php
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AffichageDataController;
use App\Http\Controllers\MutuelleController;
use App\Models\Mutuelles;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->get('/mutuelle/home', function () {
    return view('mutuelles.home');
})->name('mutuelles.home');

Route::view('/mutuelle/login', 'mutuelles/login')->name('mutuelles.home');

Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');

Route::get('/client/login', [ClientController::class, 'showLoginForm'])->name('client.login');

Route::post('/client/login', [ClientController::class, 'login'])->name('client.login.perform');

Route::get('/register', [ClientController::class, 'create'])->name('clients.register'); // formulaire
Route::post('/register', [ClientController::class, 'register'])->name('clients.store');
