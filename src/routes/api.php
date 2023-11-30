<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\UserRoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/study-program', [StudyProgramController::class, 'index']);
Route::get('/study-program/{id}', [StudyProgramController::class, 'show']);
Route::post('/study-program', [StudyProgramController::class, 'store']);
Route::put('/study-program/{id}', [StudyProgramController::class, 'update']);
Route::delete('/study-program/{id}', [StudyProgramController::class, 'destroy']);

Route::get('/user-role', [UserRoleController::class, 'index']);
Route::post('/user-role', [UserRoleController::class, 'store']);
Route::get('/user-role/{id}', [UserRoleController::class, 'show']);
Route::put('/user-role/{id}', [UserRoleController::class, 'update']);
Route::delete('/user-roles/{id}', [UserRoleController::class, 'destroy']);

Route::get('/school-subject', [SchoolSubjectController::class, 'index']);
Route::get('/school-subject/{id}', [SchoolSubjectController::class, 'show']);
Route::post('/school-subject', [SchoolSubjectController::class, 'store']);
Route::put('/school-subject/{id}', [SchoolSubjectController::class, 'update']);
Route::delete('/school-subject/{id}', [SchoolSubjectController::class, 'destroy']);
