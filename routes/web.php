<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// Authentication Routes (Guest)
// ==========================================
Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// ==========================================
// Protected Routes (All Authenticated Users)
// ==========================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('auth.editProfile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('auth.updateProfile');
    Route::get('/password/change', [AuthController::class, 'changePassword'])->name('auth.changePassword');
    Route::put('/password', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');

    // Dashboard
    Route::get('/dashboard', function () {
        $stats = [
            'users' => \App\Models\User::count(),
            'institutions' => \App\Models\Institution::count(),
            'placements' => \App\Models\Placement::count(),
            'attendances' => \App\Models\Attendance::count(),
            'logbooks' => \App\Models\Logbook::count(),
            'evaluations' => \App\Models\Evaluation::count(),
            'active_placements' => \App\Models\Placement::where('status', 'active')->count(),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // ------------------------------------------
    // View-only routes (semua role bisa lihat)
    // ------------------------------------------
    Route::get('/placements', [PlacementController::class, 'index'])->name('placements.index');
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');

    // ------------------------------------------
    // Admin only
    // ------------------------------------------
    Route::middleware('role:admin')->group(function () {
        // Users CRUD
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');

        // Institutions CRUD
        Route::get('/institutions', [InstitutionController::class, 'index'])->name('institutions.index');
        Route::get('/institutions/create', [InstitutionController::class, 'create'])->name('institutions.create');
        Route::post('/institutions', [InstitutionController::class, 'store'])->name('institutions.store');
        Route::get('/institutions/{institution}', [InstitutionController::class, 'show'])->name('institutions.show');
        Route::get('/institutions/{institution}/edit', [InstitutionController::class, 'edit'])->name('institutions.edit');
        Route::post('/institutions/{institution}', [InstitutionController::class, 'update'])->name('institutions.update');
        Route::post('/institutions/{institution}/delete', [InstitutionController::class, 'delete'])->name('institutions.delete');
    });

    // ------------------------------------------
    // Murid only — CRUD Attendance & Logbook
    // ------------------------------------------
    Route::middleware('role:murid')->group(function () {
        Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
        Route::post('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
        Route::post('/attendances/{attendance}/delete', [AttendanceController::class, 'delete'])->name('attendances.delete');

        Route::get('/logbooks/create', [LogbookController::class, 'create'])->name('logbooks.create');
        Route::post('/logbooks', [LogbookController::class, 'store'])->name('logbooks.store');
        Route::get('/logbooks/{logbook}/edit', [LogbookController::class, 'edit'])->name('logbooks.edit');
        Route::post('/logbooks/{logbook}', [LogbookController::class, 'update'])->name('logbooks.update');
        Route::post('/logbooks/{logbook}/delete', [LogbookController::class, 'delete'])->name('logbooks.delete');
    });

    // Show routes AFTER create (wildcard must come last)
    Route::get('/attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');
    Route::get('/logbooks/{logbook}', [LogbookController::class, 'show'])->name('logbooks.show');

    // ------------------------------------------
    // Guru only — CRUD Evaluation
    // ------------------------------------------
    Route::middleware('role:guru')->group(function () {
        Route::get('/evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create');
        Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('/evaluations/{evaluation}', [EvaluationController::class, 'show'])->name('evaluations.show');
        Route::get('/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
        Route::post('/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluations.update');
        Route::post('/evaluations/{evaluation}/delete', [EvaluationController::class, 'delete'])->name('evaluations.delete');
    });
});
