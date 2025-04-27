<?php
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MutuelleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AffichageDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

//Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');

Route::middleware('auth:mutuelles')
    ->get('/mutuelle/home', [MutuelleController::class, 'homeView'])->name('mutuelle.home');
Route::get('/mutuelle/login', [MutuelleController::class, 'loginView'])->name('mutuelles.login');

Route::get('/mutuelle/logout', function () {
    Auth::guard('mutuelles')->logout();

    return redirect('/');
})->name('mutuelle.logout');
Route::get('/client/login', [ClientController::class, 'showLoginForm'])->name('client.login');


Route::get('/register', [ClientController::class, 'create'])->name('clients.register'); // formulaire

Route::get('/client/logout', function () {
    Auth::guard('clients')->logout();

    return redirect('/');
})->name('client.logout');

Route::middleware('auth:clients')
    ->get('/client/home', [ClientController::class, 'homeView'])->name('client.home');
Route::get('/mutuelles/create', [MutuelleController::class, 'create'])->name('mutuelles.create');
//Route::post('/mutuelles', [MutuelleController::class, 'store'])->name('mutuelles.store');
Route::get('/mutuelles/{mutuelle}', [MutuelleController::class, 'show'])->name('mutuelles.show');

//getting edit page route
Route::get('/mutuelles/{mutuelle}/edit', [MutuelleController::class, 'edit'])->name('mutuelles.edit');
//Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');


Route::post('/mutuelle/register', [MutuelleController::class, 'register'])->name('mutuelle.register');
Route::post('/mutuelle/login', [MutuelleController::class, 'login'])->name('mutuelle.login');
Route::post('/mutuelles', [MutuelleController::class, 'store'])->name('mutuelles.store');
Route::post('/register', [ClientController::class, 'register'])->name('clients.store');
Route::middleware('auth:mutuelles')->group(function () {
    Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');
    Route::delete('/mutuelles/{mutuelle}', [MutuelleController::class, 'destroy'])->name('mutuelles.destroy');
})->name('mutuelles.update');

Route::post('/client/login', [ClientController::class, 'login'])->name('client.login');
Route::middleware('auth:mutuelles')
    ->get('/mutuelle/searchClient/{numero}', [MutuelleController::class, 'searchClientByNumeroSocial'])->name('mutuelle.searchClientByNumeroSocial');
Route::get('/mutuelle/logout', [MutuelleController::class, 'logout'])->name('mutuelle.logout');

Route::middleware(['auth:mutuelles'])->group(function () {
    Route::get('/mutuelle/clients', [MutuelleController::class, 'listeClients'])->name('mutuelle.clients');
});

Route::middleware('auth:clients')->group(function () {
    Route::get('/client/edit', [ClientController::class, 'editProfile'])->name('client.editProfile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.updateProfile');
    Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.deleteProfile');
});
