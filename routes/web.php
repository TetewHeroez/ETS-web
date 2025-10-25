<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\AttendanceScheduleController;
use App\Http\Controllers\GdkController;

Route::get('/up', function () {
    return response('OK', 200);
});

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
        // User management (admin)
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::post('/users/import', [\App\Http\Controllers\UserController::class, 'import'])->name('users.import');
        
        // User CRUD operations (superadmin only)
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    });
    
    // Routes untuk submissions (member bisa submit)
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/assignments/{assignment}/upload', [SubmissionController::class, 'upload'])->name('assignments.upload');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    
    // Routes untuk attendance/absensi
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/attendances/update', [AttendanceController::class, 'updateOrCreate'])->name('attendances.update');
        
        // Routes untuk Attendance Schedule Management
        Route::resource('attendance-schedules', AttendanceScheduleController::class);
        Route::post('/attendance-schedules/{attendanceSchedule}/toggle-open', [AttendanceScheduleController::class, 'toggleOpen'])->name('attendance-schedules.toggleOpen');
        Route::post('/attendance-schedules/{attendanceSchedule}/mark-attendance', [AttendanceScheduleController::class, 'markAttendance'])->name('attendance-schedules.markAttendance');
    });
    
    // Route untuk member melihat kehadiran sendiri
    Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('my-attendance');
    
    // Routes untuk profil (semua user bisa akses)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Routes untuk KPI (hanya admin dan superadmin)
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/kpi', [KpiController::class, 'index'])->name('kpi.index');
    });
    
    // Routes untuk Contract Management (admin dan superadmin)
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::resource('contracts', ContractController::class)->only(['index', 'edit', 'update']);
    });
    
    // Routes untuk GDK (Garis-Garis Besar Kegiatan) - Access control handled in controller
    Route::middleware('auth')->group(function () {
        Route::get('/gdk', [GdkController::class, 'index'])->name('gdk.index');
        
        // Nilai routes
        Route::post('/gdk/nilai', [GdkController::class, 'storeNilai'])->name('gdk.nilai.store');
        Route::put('/gdk/nilai/{nilai}', [GdkController::class, 'updateNilai'])->name('gdk.nilai.update');
        Route::delete('/gdk/nilai/{nilai}', [GdkController::class, 'destroyNilai'])->name('gdk.nilai.destroy');
        
        // Materi routes
        Route::post('/gdk/materi', [GdkController::class, 'storeMateri'])->name('gdk.materi.store');
        Route::put('/gdk/materi/{materi}', [GdkController::class, 'updateMateri'])->name('gdk.materi.update');
        Route::delete('/gdk/materi/{materi}', [GdkController::class, 'destroyMateri'])->name('gdk.materi.destroy');
        
        // Metode routes
        Route::post('/gdk/metode', [GdkController::class, 'storeMetode'])->name('gdk.metode.store');
        Route::put('/gdk/metode/{metode}', [GdkController::class, 'updateMetode'])->name('gdk.metode.update');
        Route::delete('/gdk/metode/{metode}', [GdkController::class, 'destroyMetode'])->name('gdk.metode.destroy');
        
        // Flowchart routes
        Route::post('/gdk/flowchart', [GdkController::class, 'storeFlowchart'])->name('gdk.flowchart.store');
        Route::put('/gdk/flowchart/{flowchart}', [GdkController::class, 'updateFlowchart'])->name('gdk.flowchart.update');
        Route::delete('/gdk/flowchart/{flowchart}', [GdkController::class, 'destroyFlowchart'])->name('gdk.flowchart.destroy');
    });
    
    // Routes untuk scoring/penilaian (admin dan superadmin) - READ ONLY
    // Scores are now auto-calculated from submissions and GDK multipliers
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/scores/{assignment}', [ScoreController::class, 'index'])->name('scores.index');
    });
    
    // Route untuk leaderboard (semua user bisa akses)
    Route::get('/leaderboard', [ScoreController::class, 'leaderboard'])->name('leaderboard');
});
