<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\InCategoryController;
use App\Http\Controllers\InProvController;
use App\Http\Controllers\InScopeController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\InsuranceUpdateController;
use App\Http\Controllers\ProblemReportController;
use App\Http\Controllers\PRCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitTypeController;
use App\Models\Insurance;
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

Route::get('product/get', [ProductController::class, 'get']);
Route::get('unit_type/get', [UnitTypeController::class, 'get']);

##EXPORT
    ##USER
    Route::get('/user/export',[UserController::class,'export']);
    Route::get('/user/export/template',[UserController::class,'template']);

    ##PRODUCT
    Route::get('/product/export',[ProductController::class,'export']);
    Route::get('/product/export/template',[ProductController::class,'template']);

    ##PROBLEM REPORT
    Route::post('/problemReport/export',[ProblemReportController::class,'export']);

    ##REQUEST
    Route::post('/request/export',[RequestController::class,'export']);

    ##INSURANCE
    Route::get('/insurance/export/template',[InsuranceController::class,'template']);

#IMPORT
    ##USER
    Route::post('/user/import',[UserController::class,'import']);

    ##PRODUCT
    Route::post('/product/import',[ProductController::class,'import']);

    ##INSURANCE
    Route::post('/insurance/import',[InsuranceController::class,'import']);

Route::group(['middleware' => ['auth', 'checkRole:1,3']], function(){
    ##MASTER DATA
    #USER
    Route::get('user', [UserController::class, 'index']);
    Route::post('/user/create', [UserController::class, 'create']);
    Route::get('/user/{user}/profile', [UserController::class, 'profile']);
    Route::get('/user/{user}/edit', [UserController::class, 'edit']);
    Route::post('/user/{user}/update', [UserController::class, 'update']);
    Route::get('/user/{user}/delete', [UserController::class, 'destroy']);
    Route::get('/user/{user}/active', [UserController::class, 'active']);

    #BARANG
    Route::get('product', [ProductController::class, 'index']);
    Route::post('/product/create', [ProductController::class, 'create']);
    Route::get('/product/{product}/edit', [ProductController::class, 'edit']);
    Route::post('/product/{product}/update', [ProductController::class, 'update']);
    Route::get('/product/{product}/delete', [ProductController::class, 'destroy']);
    
    #CATEGORY
    Route::get('category', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'create']);
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit']);
    Route::post('/category/{category}/update', [CategoryController::class, 'update']);
    Route::get('/category/{category}/delete', [CategoryController::class, 'destroy']);

    #TIPE UNIT
    Route::get('unittype', [UnitTypeController::class, 'index']);
    Route::post('/unittype/create', [UnitTypeController::class, 'create']);
    Route::get('/unittype/{unit_type}/edit', [UnitTypeController::class, 'edit']);
    Route::post('/unittype/{unit_type}/update', [UnitTypeController::class, 'update']);
    Route::get('/unittype/{unit_type}/delete', [UnitTypeController::class, 'destroy']);

    #TIPE REQUEST
    Route::get('requesttype', [RequestTypeController::class, 'index']);
    Route::post('/requesttype/create', [RequestTypeController::class, 'create']);
    Route::get('/requesttype/{request_type}/edit', [RequestTypeController::class, 'edit']);
    Route::post('/requesttype/{request_type}/update', [RequestTypeController::class, 'update']);
    Route::get('/requesttype/{request_type}/delete', [RequestTypeController::class, 'destroy']);

    ##SETTINGS
    #DIVISION
    Route::get('division', [DivisionController::class, 'index']);
    Route::post('/division/create', [DivisionController::class, 'create']);
    Route::get('/division/{division}/edit', [DivisionController::class, 'edit']);
    Route::post('/division/{division}/update', [DivisionController::class, 'update']);
    Route::get('/division/{division}/delete', [DivisionController::class, 'destroy']);

    #ROLE
    Route::get('role', [RoleController::class, 'index']);
    Route::post('/role/create', [RoleController::class, 'create']);
    Route::get('/role/{role}/edit', [RoleController::class, 'edit']);
    Route::post('/role/{role}/update', [RoleController::class, 'update']);
    Route::get('/role/{role}/delete', [RoleController::class, 'destroy']);

    #BADAN USAHA
    Route::get('bu', [BadanUsahaController::class, 'index']);
    Route::post('/bu/create', [BadanUsahaController::class, 'create']);
    Route::get('/bu/{bu}/edit', [BadanUsahaController::class, 'edit']);
    Route::post('/bu/{bu}/update', [BadanUsahaController::class, 'update']);
    Route::get('/bu/{bu}/delete', [BadanUsahaController::class, 'destroy']);

    #AREA
    Route::get('area', [AreaController::class, 'index']);
    Route::post('/area/create', [AreaController::class, 'create']);
    Route::get('/area/{area}/edit', [AreaController::class, 'edit']);
    Route::post('/area/{area}/update', [AreaController::class, 'update']);
    Route::get('/area/{area}/delete', [AreaController::class, 'destroy']);

    ##INSURANCE
    #INSURANCE
    Route::get('insurance', [InsuranceController::class, 'index']);
    Route::post('/insurance/store', [InsuranceController::class, 'store']);
    Route::get('/insurance/{insurance}/edit', [InsuranceController::class, 'edit']);
    Route::post('/insurance/{insurance}/update', [InsuranceController::class, 'update']);
    Route::get('/insurance/{insurance}/delete', [InsuranceController::class, 'destroy']);
    Route::get('/insurance/{id}', [InsuranceController::class, 'show']);
    Route::post('/insurance/storeUpdate', [InsuranceController::class, 'storeUpdate']);

    #INSURANCE UPDATE
    Route::get('/insurance/{id}/editUpdate', [InsuranceUpdateController::class, 'editUpdate']);
    Route::post('/insurance/{insuranceUpdate}/updateInsuranceUpdate', [InsuranceUpdateController::class, 'updateInsuranceUpdate']);
    Route::get('/insurance/{insuranceUpdate}/deleteUpdate/{insurance}', [InsuranceUpdateController::class, 'deleteUpdate']);

    #INSURANCE PROVIDERS
    Route::get('inprov', [InProvController::class, 'index']);
    Route::post('/inprov/store', [InProvController::class, 'store']);
    Route::get('/inprov/{inprov}/edit', [InProvController::class, 'edit']);
    Route::post('/inprov/{inprov}/update', [InProvController::class, 'update']);
    Route::get('/inprov/{inprov}/delete', [InProvController::class, 'destroy']);

    #INSURANCE SCOPES
    Route::get('inscope', [InScopeController::class, 'index']);
    Route::post('/inscope/store', [InScopeController::class, 'store']);
    Route::get('/inscope/{inscope}/edit', [InScopeController::class, 'edit']);
    Route::post('/inscope/{inscope}/update', [InScopeController::class, 'update']);
    Route::get('/inscope/{inscope}/delete', [InScopeController::class, 'destroy']);

    #INSURANCE CATEGORY
    Route::get('incategory', [InCategoryController::class, 'index']);
    Route::post('/incategory/store', [InCategoryController::class, 'store']);
    Route::get('/incategory/{incategory}/edit', [InCategoryController::class, 'edit']);
    Route::post('/incategory/{incategory}/update', [InCategoryController::class, 'update']);
    Route::get('/incategory/{incategory}/delete', [InCategoryController::class, 'destroy']);

});

Route::group(['middleware' => ['auth', 'checkRole:1,2,3,4']], function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware();
    Route::get('search', [DashboardController::class, 'search']);

    ##PROBLEM REPORT
    Route::get('/problemReport', [ProblemReportController::class, 'index']);
    Route::get('/problemReport/create', [ProblemReportController::class, 'create']);
    Route::post('/problemReport/store', [ProblemReportController::class, 'store']);
    Route::get('/problemReport/{problem}/editStatus', [ProblemReportController::class, 'editStatus']);
    Route::post('/problemReport/{problem}/updateStatus', [ProblemReportController::class, 'updateStatus']);
    Route::get('/problemReport/{problem}/editStatusClient', [ProblemReportController::class, 'editStatusClient']);
    Route::post('/problemReport/{problem}/updateStatusClient', [ProblemReportController::class, 'updateStatusClient']);

    ##PROBLEM REPORT CATEGORY
    Route::get('/prcategory', [PRCategoryController::class, 'index']);
    Route::post('/prcategory/create', [PRCategoryController::class, 'create']);
    Route::get('/prcategory/{prcategory}/edit', [PRCategoryController::class, 'edit']);
    Route::post('/prcategory/{prcategory}/update', [PRCategoryController::class, 'update']);
    Route::get('/prcategory/{prcategory}/delete', [PRCategoryController::class, 'destroy']);

    ##REQUEST
    Route::get('/request', [RequestController::class, 'index']);
    Route::get('/request/create', [RequestController::class, 'create']);
    Route::post('/request/store', [RequestController::class, 'store']);
    Route::post('/fixRequest/{id}', [RequestController::class, 'fixRequest']);
    Route::get('/request/{id}', [RequestController::class, 'show']);
    Route::get('/editRequest/{id}', [RequestController::class, 'showEditPage']);
    Route::post('/request/{id}/updateRequest', [RequestController::class, 'updateRequest']);
    Route::get('/request/{requestBarang}/editStatus', [RequestController::class, 'editStatus']);
    Route::post('/request/{requestBarang}/updateStatus', [RequestController::class, 'updateStatus']);
    Route::get('/request/{requestBarang}/editStatusClient', [RequestController::class, 'editStatusClient']);
    Route::post('/request/{requestBarang}/updateStatusClient', [RequestController::class, 'updateStatusClient']);
    Route::get('/request/{requestBarang}/editStatusAcc', [RequestController::class, 'editStatusAcc']);
    Route::post('/request/{requestBarang}/updateStatusAcc', [RequestController::class, 'updateStatusAcc']);
    Route::get('/request/{requestBarang}/cancelRequest', [RequestController::class, 'cancelRequest']);
});

