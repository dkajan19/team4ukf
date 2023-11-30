<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\SchoolSubjectController;



Route::get('/', function () {
    return view('welcome');
});

//Route::get('/study_program', [StudyProgramController::class, 'index'])->name('study_program.index');
//Route::get('/study_program/{id}', [StudyProgramController::class, 'show'])->name('study_program.show');
//Route::get('/study_program/{id}/edit', [StudyProgramController::class, 'edit'])->name('study_program.edit');
//Route::put('/study_program/{id}', [StudyProgramController::class, 'update'])->name('study_program.update');
//Route::delete('/study_program/{id}', [StudyProgramController::class, 'destroy'])->name('study_program.destroy');
//Route::post('/study_program', [StudyProgramController::class, 'store'])->name('study_program.store');

//Route::get('/user_role', [UserRoleController::class, 'index'])->name('user_role.index');
//Route::post('/user_role', [UserRoleController::class, 'store'])->name('user_role.store');
//Route::get('/user_role/{id}', [UserRoleController::class, 'show'])->name('user_role.show');
//Route::get('/user_role/{id}/edit', [UserRoleController::class, 'edit'])->name('user_role.edit');
//Route::put('/user_role/{id}', [UserRoleController::class, 'update'])->name('user_role.update');
//Route::delete('/user_role/{id}', [UserRoleController::class, 'destroy'])->name('user_role.destroy');

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/study_program', [StudyProgramController::class, 'index'])->name('study_program.index');
    Route::get('/study_program/{id}', [StudyProgramController::class, 'show'])->name('study_program.show');
    Route::get('/study_program/{id}/edit', [StudyProgramController::class, 'edit'])->name('study_program.edit');
    Route::put('/study_program/{id}', [StudyProgramController::class, 'update'])->name('study_program.update');
    Route::delete('/study_program/{id}', [StudyProgramController::class, 'destroy'])->name('study_program.destroy');
    Route::post('/study_program', [StudyProgramController::class, 'store'])->name('study_program.store');
    Route::get('/user_role', [UserRoleController::class, 'index'])->name('user_role.index');
    Route::post('/user_role', [UserRoleController::class, 'store'])->name('user_role.store');
    Route::get('/user_role/{id}', [UserRoleController::class, 'show'])->name('user_role.show');
    Route::get('/user_role/{id}/edit', [UserRoleController::class, 'edit'])->name('user_role.edit');
    Route::put('/user_role/{id}', [UserRoleController::class, 'update'])->name('user_role.update');
    Route::delete('/user_role/{id}', [UserRoleController::class, 'destroy'])->name('user_role.destroy');
    Route::get('/contract', [ContractController::class, 'index'])->name('contract.index');
    Route::get('/contract/{id}', [ContractController::class, 'show'])->name('contract.show');
    Route::get('/contract/{id}/edit', [ContractController::class, 'edit'])->name('contract.edit');
    Route::put('/contract/{id}', [ContractController::class, 'update'])->name('contract.update');
    Route::delete('/contract/{id}', [ContractController::class, 'destroy'])->name('contract.destroy');
    Route::post('/contract', [ContractController::class, 'store'])->name('contract.store');


});

Route::get('/school_subject', [SchoolSubjectController::class, 'index'])->name('school_subject.index');
Route::get('/school_subject/{id}', [SchoolSubjectController::class, 'show'])->name('school_subject.show');
Route::get('/school_subject/{id}/edit', [SchoolSubjectController::class, 'edit'])->name('school_subject.edit');
Route::put('/school_subject/{id}', [SchoolSubjectController::class, 'update'])->name('school_subject.update');
Route::delete('/school_subject/{id}', [SchoolSubjectController::class, 'destroy'])->name( 'school_subject.destroy');
Route::post('/school_subject', [SchoolSubjectController::class, 'store'])->name('school_subject.store');
