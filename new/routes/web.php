<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', function () {
    return view('dashboard');
})->('dashboard')->middleware('auth'); // Ensure only authenticated users access dashboard

require __DIR__.'/auth.php';
