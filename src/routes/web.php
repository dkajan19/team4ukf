<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/study_program', [StudyProgramController::class, 'index'])->name('study_program.index');
Route::get('/study_program/{id}', [StudyProgramController::class, 'show'])->name('study_program.show');
Route::get('/study_program/{id}/edit', [StudyProgramController::class, 'edit'])->name('study_program.edit');
Route::put('/study_program/{id}', [StudyProgramController::class, 'update'])->name('study_program.update');
Route::delete('/study_program/{id}', [StudyProgramController::class, 'destroy'])->name('study_program.destroy');
Route::post('/study_program', [StudyProgramController::class, 'store'])->name('study_program.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});