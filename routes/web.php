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

// Route that verifies and deactivates a scanned pass
Route::get('/verify-scan/{token}', [VisitorController::class, 'verifyScan'])->name('visitor.verify');

// The Administration Dashboard Overview URL
Route::get('/admin/dashboard', [App\Http\Controllers\VisitorController::class, 'showAdminDashboard'])->name('admin.dashboard');

// The URL path for the camera scanner page
Route::get('/gate/scanner', function () {
    return view('gate-scanner');
})->name('gate.scanner');

// Route that explicitly accepts both the unique tracking token AND the scanning station office location
Route::get('/verify-scan/{token}/{location}', [App\Http\Controllers\VisitorController::class, 'verifyScan'])->name('visitor.verify');

// Route that accepts a token and an optional station location
Route::get('/verify-scan/{token}/{location?}', [App\Http\Controllers\VisitorController::class, 'verifyScan'])->name('visitor.verify');

// Authentication Screen Views and Form Processors
Route::get('/admin/login', [App\Http\Controllers\VisitorController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\VisitorController::class, 'processLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\VisitorController::class, 'processLogout'])->name('admin.logout');


// Put this line near your other admin routes
Route::delete('/admin/visitor/{id}', [VisitorController::class, 'destroyVisitor'])->name('admin.delete-visitor');