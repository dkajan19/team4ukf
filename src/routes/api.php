<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('/user-role', [UserRoleController::class, 'index']);
Route::post('/user-role', [UserRoleController::class, 'store']);
Route::get('/user-role/{id}', [UserRoleController::class, 'show']);
Route::put('/user-role/{id}', [UserRoleController::class, 'update']);
Route::delete('/user-roles/{id}', [UserRoleController::class, 'destroy']);
