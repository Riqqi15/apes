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

Route::get('/', function () { return view('welcome'); });

Route::get('/login', [AuthPageController::class, 'login'])->name('login');
Route::get('/register', [AuthPageController::class, 'register'])->name('register');

Route::get('/dashboard/hr', [HrController::class, 'index'])->name('dashboard.hr');
Route::get('/dashboard/direktur', [DirekturController::class, 'index'])->name('dashboard.direktur');
Route::get('/dashboard/karyawan', [KaryawanController::class, 'index'])->name('dashboard.karyawan');

Route::get('/rekap', [RecapController::class, 'index'])->name('rekap');
Route::get('/rekap/{id}', [RecapController::class, 'show'])->name('rekap.show');

Route::get('/kelola/karyawan', [EmployeeController::class, 'index'])->name('kelola.karyawan');
Route::get('/kelola/karyawan/create', [EmployeeController::class, 'create'])->name('kelola.karyawan.create');
Route::get('/kelola/karyawan/{id}/edit', [EmployeeController::class, 'edit'])->name('kelola.karyawan.edit');
Route::get('/biodata', [EmployeeController::class, 'edit'])->name('biodata.edit');

Route::get('/kelola/variabel', [VariableController::class, 'index'])->name('kelola.variabel');
Route::get('/kelola/indikator', [IndicatorController::class, 'index'])->name('kelola.indikator');

Route::get('/kelola/penilaian', [AssessmentController::class, 'periods'])->name('kelola.penilaian');
Route::get('/penilaian/assignments', [AssessmentController::class, 'assignments'])->name('penilaian.assignments');
Route::get('/penilaian/form', [AssessmentController::class, 'form'])->name('penilaian.form');
Route::get('/penilaian/hasil', [AssessmentController::class, 'personalResult'])->name('penilaian.hasil');

Route::get('/laporan/cetak', [ReportController::class, 'print'])->name('laporan.cetak');
