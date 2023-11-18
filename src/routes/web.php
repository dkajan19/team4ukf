<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/study_program', [StudyProgramController::class, 'index'])->name('study_program.index');
Route::get('/study_program/{id}', [StudyProgramController::class, 'show'])->name('study_program.show');
Route::get('/study_program/{id}/edit', [StudyProgramController::class, 'edit'])->name('study_program.edit');
Route::put('/study_program/{id}', [StudyProgramController::class, 'update'])->name('study_program.update');
Route::delete('/study_program/{id}', [StudyProgramController::class, 'destroy'])->name('study_program.destroy');
Route::post('/study_program', [StudyProgramController::class, 'store'])->name('study_program.store');