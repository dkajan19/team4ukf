<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyProgramController;

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
