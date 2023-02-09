<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ProblemReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitTypeController;
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

Route::group(['middleware' => ['auth', 'checkRole:1']], function(){
    ##MASTER DATA
    #USER
    Route::get('user', [UserController::class, 'index']);
    Route::post('/user/create', [UserController::class, 'create']);
    Route::get('/user/{id}/profile', [UserController::class, 'profile']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::post('/user/{id}/update', [UserController::class, 'update']);
    Route::get('/user/{id}/delete', [UserController::class, 'destroy']);

    #BARANG
    Route::get('product', [ProductController::class, 'index']);
    Route::post('/product/create', [ProductController::class, 'create']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
    Route::post('/product/{id}/update', [ProductController::class, 'update']);
    Route::get('/product/{id}/delete', [ProductController::class, 'destroy']);

    Route::get('/product/download', [ProductController::class, 'download']);
    
    #CATEGORY
    Route::get('category', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'create']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/category/{id}/update', [CategoryController::class, 'update']);
    Route::get('/category/{id}/delete', [CategoryController::class, 'destroy']);

    #TIPE UNIT
    Route::get('unittype', [UnitTypeController::class, 'index']);
    Route::post('/unittype/create', [UnitTypeController::class, 'create']);
    Route::get('/unittype/{id}/edit', [UnitTypeController::class, 'edit']);
    Route::post('/unittype/{id}/update', [UnitTypeController::class, 'update']);
    Route::get('/unittype/{id}/delete', [UnitTypeController::class, 'destroy']);

    #TIPE REQUEST
    Route::get('requesttype', [RequestTypeController::class, 'index']);
    Route::post('/requesttype/create', [RequestTypeController::class, 'create']);
    Route::get('/requesttype/{id}/edit', [RequestTypeController::class, 'edit']);
    Route::post('/requesttype/{id}/update', [RequestTypeController::class, 'update']);
    Route::get('/requesttype/{id}/delete', [RequestTypeController::class, 'destroy']);

    ##SETTINGS
    #DIVISION
    Route::get('division', [DivisionController::class, 'index']);
    Route::post('/division/create', [DivisionController::class, 'create']);
    Route::get('/division/{id}/edit', [DivisionController::class, 'edit']);
    Route::post('/division/{id}/update', [DivisionController::class, 'update']);
    Route::get('/division/{id}/delete', [DivisionController::class, 'destroy']);

    #ROLE
    Route::get('role', [RoleController::class, 'index']);
    Route::post('/role/create', [RoleController::class, 'create']);
    Route::get('/role/{id}/edit', [RoleController::class, 'edit']);
    Route::post('/role/{id}/update', [RoleController::class, 'update']);
    Route::get('/role/{id}/delete', [RoleController::class, 'destroy']);

    #BADAN USAHA
    Route::get('bu', [BadanUsahaController::class, 'index']);
    Route::post('/bu/create', [BadanUsahaController::class, 'create']);
    Route::get('/bu/{id}/edit', [BadanUsahaController::class, 'edit']);
    Route::post('/bu/{id}/update', [BadanUsahaController::class, 'update']);
    Route::get('/bu/{id}/delete', [BadanUsahaController::class, 'destroy']);

    #AREA
    Route::get('area', [AreaController::class, 'index']);
    Route::post('/area/create', [AreaController::class, 'create']);
    Route::get('/area/{id}/edit', [AreaController::class, 'edit']);
    Route::post('/area/{id}/update', [AreaController::class, 'update']);
    Route::get('/area/{id}/delete', [AreaController::class, 'destroy']);
});

Route::group(['middleware' => ['auth', 'checkRole:1,2,3,4']], function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware();
    Route::get('search', [DashboardController::class, 'search']);

    ##PROBLEM REPORT
    Route::get('/problemReport', [ProblemReportController::class, 'index']);
    Route::post('/problemReport/create', [ProblemReportController::class, 'create']);
    Route::post('/problemReport/{id}/updateStatusClient', [ProblemReportController::class, 'updateStatusClient']);
    Route::post('/problemReport/{id}/updateStatus', [ProblemReportController::class, 'updateStatus']);
});

