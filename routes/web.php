<?php

use App\Http\Controllers\AffichageDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mutuelles', [AffichageDataController::class, 'mutelles'])->name('mutuelles');
