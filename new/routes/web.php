<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController; // Handles role-based redirection

// ✅ Default Landing Page
// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

// ✅ Guest Routes (Users who are NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [AuthenticatedSessionController::class, 'registerForm'])->name('register');
    Route::post('register', [AuthenticatedSessionController::class, 'register']);
});

// ✅ Redirect Users Based on Role (After Login)
Route::get('/home', [HomeController::class, 'redirect'])->middleware('auth')->name('home');

// ✅ Authenticated Users (Normal Users & Admins)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Normal Users Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Equipment Routes (For normal users)
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::post('/equipment/book', [EquipmentController::class, 'book'])->name('equipment.book');
});

// ✅ Admin Routes (Only for Admins)
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [EquipmentController::class, 'adminDashboard'])->name('admin.dashboard');

    // Equipment management
    Route::get('/equipment', [EquipmentController::class, 'adminIndex'])->name('admin.equipment.index');
    Route::get('/equipment/create', [EquipmentController::class, 'create'])->name('admin.equipment.create');
    Route::post('/equipment/store', [EquipmentController::class, 'store'])->name('admin.equipment.store');
    Route::get('/equipment/{id}/edit', [EquipmentController::class, 'edit'])->name('admin.equipment.edit');
    Route::post('/equipment/{id}/update', [EquipmentController::class, 'update'])->name('admin.equipment.update');
    Route::post('/equipment/{id}/approve', [EquipmentController::class, 'approve'])->name('admin.equipment.approve');
    Route::post('/equipment/{id}/return', [EquipmentController::class, 'markAsReturned'])->name('admin.equipment.return');
    Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy'])->name('admin.equipment.delete');

    // Booking management
    Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings');
});
