<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\EvaluationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Routes for all tables
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/institutions', [InstitutionController::class, 'index'])->name('institutions.index');
Route::get('/placements', [PlacementController::class, 'index'])->name('placements.index');
Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
