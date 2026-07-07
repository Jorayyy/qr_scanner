<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\UserController; // 👈 CRITICAL: Import your new user controller

// -----------------------------------------------------------------
// PUBLIC GUEST ROUTES (No Authentication Needed)
// -----------------------------------------------------------------

// The default welcome page
Route::get('/', function () {
    return view('welcome');
});

// The Visitor Registration Form Page
Route::get('/register', [VisitorController::class, 'showRegisterForm'])->name('visitor.register');

// The Action that handles form submissions
Route::post('/register', [VisitorController::class, 'storeVisitor'])->name('visitor.store');

// Route that accepts a token and an optional station location for scanning
Route::get('/verify-scan/{token}/{location?}', [VisitorController::class, 'verifyScan'])->name('visitor.verify');

// Authentication Screen Views and Form Processors
Route::get('/admin/login', [VisitorController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [VisitorController::class, 'processLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [VisitorController::class, 'processLogout'])->name('admin.logout');


// -----------------------------------------------------------------
// 🔒 PROTECTED TERMINAL & ADMIN ROUTES (Only Logged-in Users)
// -----------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    
    // The Administration Dashboard Overview Portal URL
    Route::get('/admin/dashboard', [VisitorController::class, 'showAdminDashboard'])->name('admin.dashboard');
    
    // The URL path for the camera scanner terminal page
    Route::get('/gate/scanner', function () {
        return view('gate-scanner');
    })->name('gate.scanner');

    // Route to delete a visitor record from the dashboard table rows
    Route::delete('/admin/visitor/{id}', [VisitorController::class, 'destroyVisitor'])->name('admin.delete-visitor');

    // 👤 SYSTEM USER MANAGEMENT SUB-ROUTES (Add, Edit, View Guards/Admins)
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
});
