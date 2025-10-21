<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreController;

// Halaman utama redirect ke login jika belum login, atau ke dashboard jika sudah login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Routes untuk authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes yang memerlukan authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    
    // Routes untuk melihat progress (semua role bisa akses)
    Route::get('/submissions/table', [SubmissionController::class, 'table'])->name('submissions.table');
    
    // Routes untuk assignments (hanya admin dan superadmin)
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    });
    
    // Routes untuk submissions (member bisa submit)
    Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    
    // Routes untuk attendance/absensi
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances/update', [AttendanceController::class, 'updateOrCreate'])->name('attendances.update');
    });
    
    // Route untuk member melihat kehadiran sendiri
    Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('my-attendance');
    
    // Routes untuk profil (semua user bisa akses)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Routes untuk scoring/penilaian (admin dan superadmin)
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/scores/{assignment}', [ScoreController::class, 'index'])->name('scores.index');
        Route::post('/scores/{assignment}', [ScoreController::class, 'store'])->name('scores.store');
    });
    
    // Route untuk leaderboard (semua user bisa akses)
    Route::get('/leaderboard', [ScoreController::class, 'leaderboard'])->name('leaderboard');
});
