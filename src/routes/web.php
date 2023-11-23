<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;

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

Route::get('/user_role', [UserRoleController::class, 'index'])->name('user_role.index');
Route::post('/user_role', [UserRoleController::class, 'store'])->name('user_role.store');
Route::get('/user_role/{id}', [UserRoleController::class, 'show'])->name('user_role.show');
Route::get('/user_role/{id}/edit', [UserRoleController::class, 'edit'])->name('user_role.edit');
Route::put('/user_role/{id}', [UserRoleController::class, 'update'])->name('user_role.update');
Route::delete('/user_role/{id}', [UserRoleController::class, 'destroy'])->name('user_role.destroy');

