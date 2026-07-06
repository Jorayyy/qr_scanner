<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;

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
// ⭐ FIXED: Added ->name('login') here so the security guard knows where to send visitors!
Route::get('/admin/login', [VisitorController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [VisitorController::class, 'processLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [VisitorController::class, 'processLogout'])->name('admin.logout');


// 🔒 SECURE ROUTES: Only logged-in administrators can access these pages
Route::middleware(['auth'])->group(function () {
    
    // The Administration Dashboard Overview URL using your correct controller method
    Route::get('/admin/dashboard', [VisitorController::class, 'showAdminDashboard'])->name('admin.dashboard');
    
    // The URL path for the camera scanner page
    Route::get('/gate/scanner', function () {
        return view('gate-scanner');
    })->name('gate.scanner');

    // Route to delete a visitor record
    Route::delete('/admin/visitor/{id}', [VisitorController::class, 'destroyVisitor'])->name('admin.delete-visitor');
    
});

Route::middleware(['auth'])->group(function () {
    
    // The main dashboard portal page link
    Route::get('/admin/dashboard', [VisitorController::class, 'showAdminDashboard'])->name('admin.dashboard');
    
    // The single-row database removal action button trigger
    Route::delete('/admin/visitor/{id}', [VisitorController::class, 'destroyVisitor'])->name('admin.delete-visitor');
    
});
