<?php

use App\Http\Controllers\MutuelleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AffichageDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

 Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');

Route::middleware('auth:mutuelles')
    ->get('/mutuelle/home', [MutuelleController::class, 'homeView'])->name('mutuelle.home');

Route::get('/mutuelle/login', [MutuelleController::class, 'loginView'])->name('mutuelles.login');

Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');

Route::get('/mutuelle/logout', function () {
    Auth::guard('mutuelles')->logout();

    return redirect('/');
})->name('mutuelle.logout');

Route::get('/mutuelles/create', [MutuelleController::class, 'create'])->name('mutuelles.create');
Route::post('/mutuelles', [MutuelleController::class, 'store'])->name('mutuelles.store');
Route::get('/mutuelles/{mutuelle}', [MutuelleController::class, 'show'])->name('mutuelles.show');

//getting edit page route
Route::get('/mutuelles/{mutuelle}/edit', [MutuelleController::class, 'edit'])->name('mutuelles.edit');
Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');


Route::delete('/mutuelles/{mutuelle}', [MutuelleController::class, 'destroy'])->name('mutuelles.destroy');

