<?php

use App\Http\Controllers\AffichageDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutuelleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');

Route::get('/mutuelles/create', [MutuelleController::class, 'create'])->name('mutuelles.create');
Route::post('/mutuelles', [MutuelleController::class, 'store'])->name('mutuelles.store');
Route::get('/mutuelles/{mutuelle}', [MutuelleController::class, 'show'])->name('mutuelles.show');

//getting edit page route
Route::get('/mutuelles/{mutuelle}/edit', [MutuelleController::class, 'edit'])->name('mutuelles.edit');
Route::put('/mutuelles/{mutuelle}', [MutuelleController::class, 'update'])->name('mutuelles.update');


Route::delete('/mutuelles/{mutuelle}', [MutuelleController::class, 'destroy'])->name('mutuelles.destroy');

