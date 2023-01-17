<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auths.login');
})->name('/');

#LOGIN
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('/postlogin', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth'], function(){

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware();

    #USER
    Route::get('user', [UserController::class, 'index']);
    Route::get('/user/{id}/profile', [UserController::class, 'profile']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::post('/user/{id}/update', [UserController::class, 'update']);

    #CATEGORY
    Route::get('category', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'create']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/category/{id}/update', [CategoryController::class, 'update']);
    Route::get('/category/{id}/delete', [CategoryController::class, 'destroy']);

});

