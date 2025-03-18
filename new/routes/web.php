<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


// ✅ Guest routes (for users who are not logged in)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ✅ Authenticated users (both admins and normal users)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Equipment Routes (For normal users)
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::post('/equipment/book', [EquipmentController::class, 'book'])->name('equipment.book');
});

// ✅ Admin-only routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [EquipmentController::class, 'adminDashboard'])->name('admin.dashboard');

    // Equipment management
    Route::get('/admin/equipment', [EquipmentController::class, 'adminIndex'])->name('admin.equipment.index');
    Route::get('/admin/equipment/create', [EquipmentController::class, 'create'])->name('admin.equipment.create');
    Route::post('/admin/equipment/store', [EquipmentController::class, 'store'])->name('admin.equipment.store');
    Route::get('/admin/equipment/{id}/edit', [EquipmentController::class, 'edit'])->name('admin.equipment.edit');
    Route::post('/admin/equipment/{id}/update', [EquipmentController::class, 'update'])->name('admin.equipment.update');
    Route::post('/admin/equipment/{id}/approve', [EquipmentController::class, 'approve'])->name('admin.equipment.approve');
    Route::post('/admin/equipment/{id}/return', [EquipmentController::class, 'markAsReturned'])->name('admin.equipment.return');
    Route::delete('/admin/equipment/{id}', [EquipmentController::class, 'destroy'])->name('admin.equipment.delete');

    // Booking management
    Route::get('/admin/bookings', [BookingController::class, 'index'])->name('admin.bookings');
});