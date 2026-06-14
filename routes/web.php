<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthPageController;
use App\Http\Controllers\Dashboard\HrController;
use App\Http\Controllers\Dashboard\DirekturController;
use App\Http\Controllers\Dashboard\KaryawanController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\VariableController;
use App\Http\Controllers\Employee\IndicatorController;
use App\Http\Controllers\Assessment\AssessmentController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Recap\RecapController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->akses_user) {
        'hr' => redirect()->route('dashboard.hr'),
        'direktur' => redirect()->route('dashboard.direktur'),
        default => redirect()->route('dashboard.karyawan'),
    };
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthPageController::class, 'login'])->name('login');
    Route::post('/login', [AuthPageController::class, 'authenticate'])->name('login.attempt');
    Route::get('/register', [AuthPageController::class, 'register'])->name('register');
    Route::post('/register', [AuthPageController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthPageController::class, 'logout'])->name('logout');

    Route::middleware('role:hr')->group(function () {
        Route::get('/dashboard/hr', [HrController::class, 'index'])->name('dashboard.hr');
        Route::get('/kelola/karyawan', [EmployeeController::class, 'index'])->name('kelola.karyawan');
        Route::get('/kelola/karyawan/create', [EmployeeController::class, 'create'])->name('kelola.karyawan.create');
        Route::post('/kelola/karyawan', [EmployeeController::class, 'store'])->name('kelola.karyawan.store');
        Route::get('/kelola/karyawan/{id}/edit', [EmployeeController::class, 'edit'])->name('kelola.karyawan.edit');
        Route::put('/kelola/karyawan/{id}', [EmployeeController::class, 'update'])->name('kelola.karyawan.update');
        Route::delete('/kelola/karyawan/{id}', [EmployeeController::class, 'destroy'])->name('kelola.karyawan.destroy');
        Route::get('/kelola/variabel', [VariableController::class, 'index'])->name('kelola.variabel');
        Route::get('/kelola/indikator', [IndicatorController::class, 'index'])->name('kelola.indikator');
        Route::get('/kelola/penilaian', [AssessmentController::class, 'periods'])->name('kelola.penilaian');
        Route::post('/kelola/penilaian/periode', [AssessmentController::class, 'storePeriod'])->name('kelola.penilaian.periods.store');
        Route::put('/kelola/penilaian/periode/{periode}', [AssessmentController::class, 'updatePeriod'])->name('kelola.penilaian.periods.update');
        Route::delete('/kelola/penilaian/periode/{periode}', [AssessmentController::class, 'destroyPeriod'])->name('kelola.penilaian.periods.destroy');
        Route::post('/kelola/penilaian/assignment', [AssessmentController::class, 'storeAssignment'])->name('kelola.penilaian.assignments.store');
        Route::put('/kelola/penilaian/assignment/{assignment}', [AssessmentController::class, 'updateAssignment'])->name('kelola.penilaian.assignments.update');
        Route::delete('/kelola/penilaian/assignment/{assignment}', [AssessmentController::class, 'destroyAssignment'])->name('kelola.penilaian.assignments.destroy');
    });

    Route::middleware('role:direktur')->group(function () {
        Route::get('/dashboard/direktur', [DirekturController::class, 'index'])->name('dashboard.direktur');
        Route::get('/rekap', [RecapController::class, 'index'])->name('rekap');
        Route::get('/rekap/{id}', [RecapController::class, 'show'])->name('rekap.show');
        Route::get('/rekap/{id}/edit', [RecapController::class, 'edit'])->name('rekap.edit');
        Route::put('/rekap/{id}', [RecapController::class, 'update'])->name('rekap.update');
        Route::get('/laporan/cetak/{id}', [ReportController::class, 'print'])->middleware('signed')->name('laporan.cetak');
    });

    Route::middleware('role:karyawan')->group(function () {
        Route::get('/dashboard/karyawan', [KaryawanController::class, 'index'])->name('dashboard.karyawan');
        Route::get('/biodata', [EmployeeController::class, 'edit'])->name('biodata.edit');
        Route::put('/biodata', [EmployeeController::class, 'update'])->name('biodata.update');
        Route::get('/penilaian/assignments', [AssessmentController::class, 'assignments'])->name('penilaian.assignments');
        Route::get('/penilaian/form', [AssessmentController::class, 'form'])->name('penilaian.form');
        Route::get('/penilaian/hasil', [AssessmentController::class, 'personalResult'])->name('penilaian.hasil');
    });
});
