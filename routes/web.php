<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusLocationController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GateScannerController; 
use App\Models\CampusLocation;
use App\Http\Controllers\VisitorIdVerificationController;

// -----------------------------------------------------------------
// PUBLIC GUEST ROUTES (No Authentication Needed)
// -----------------------------------------------------------------

// The default welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// The Visitor Registration Form Page
Route::get('/register', [VisitorController::class, 'showRegisterForm'])->name('visitor.register');

// The Action that handles form submissions
Route::post('/register', [VisitorController::class, 'storeVisitor'])->name('visitor.store');

// Reissue links for existing returning users
Route::get('/visitor/reissue', [VisitorController::class, 'showReissueForm'])->name('visitor.reissue');
Route::post('/visitor/reissue', [VisitorController::class, 'processReissue'])->name('visitor.reissue.submit');

// Permanent public URL for the visitor's live pass hub profile
Route::get('/pass/{token}', [VisitorController::class, 'showLivePass'])->name('visitor.live.pass');

// Authentication Screen Views and Form Processors (✅ FIX: Matches admin.login.submit and admin.logout)
Route::get('/admin/login', [VisitorController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [VisitorController::class, 'processLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [VisitorController::class, 'processLogout'])->name('admin.logout');

// -----------------------------------------------------------------
// 🔒 PROTECTED TERMINAL & ADMIN ROUTES (Only Logged-in Users)
// -----------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    
    // SECURED: Route that accepts a token and validates it for scanning terminal results
    Route::get('/verify-scan/{token}/{location?}', [VisitorController::class, 'verifyScan'])->name('visitor.verify');

    // The Administration Dashboard Overview Portal URL
    Route::get('/admin/dashboard', [VisitorController::class, 'showAdminDashboard'])->name('admin.dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/campus-locations', [CampusLocationController::class, 'index'])->name('campus.locations.index');
        Route::post('/admin/campus-locations', [CampusLocationController::class, 'store'])->name('campus.locations.store');
        Route::put('/admin/campus-locations/{campusLocation}', [CampusLocationController::class, 'update'])->name('campus.locations.update');
        Route::delete('/admin/campus-locations/{campusLocation}', [CampusLocationController::class, 'destroy'])->name('campus.locations.destroy');
    });
    
    // The URL path for the camera scanner terminal page
    Route::get('/gate/scanner', function () {
        $campusLocations = CampusLocation::active()
            ->ordered()
            ->forUsage(['scanner', 'shared'])
            ->get();

        return view('gate-scanner', compact('campusLocations'));
    })->name('gate.scanner');

    // Route to delete a visitor record from the dashboard table rows (admin only)
    Route::delete('/admin/visitor/{id}', [VisitorController::class, 'destroyVisitor'])
        ->middleware('role:admin')
        ->name('admin.delete-visitor');

    // Route to preview stored visitor ID images safely across environments
    Route::get('/admin/visitor/{id}/id-preview', [VisitorController::class, 'showVisitorIdPreview'])
        ->name('admin.visitor-id-preview');

    // 👤 SYSTEM USER MANAGEMENT SUB-ROUTES (Add, Edit, View Guards/Admins)
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
});

// Async lookup route for the guard dashboard terminal panel
Route::get('/visitor/lookup', [VisitorController::class, 'expressLookup'])->name('visitor.lookup');



// Universal Terminal Sync Route Tracking Pipeline
Route::get('/verify-scan/{token}/{location}', [GateScannerController::class, 'processPassTransaction'])
     ->name('gate.verify');

// 1. The separate page showing the ID upload form
Route::get('/verify-id', [VisitorIdVerificationController::class, 'showUploadPage'])
    ->name('visitor.verify.upload');

// Reset the verified identity session so a new visitor can be registered
Route::get('/verify-id/reset', [VisitorIdVerificationController::class, 'resetVerification'])
    ->name('visitor.verify.reset');

// 2. The endpoint that processes the uploaded image through Tesseract OCR
Route::post('/verify-id', [VisitorIdVerificationController::class, 'verifyId'])
    ->name('visitor.verify.process');
