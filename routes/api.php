<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    ['prefix'=>'v1','as'=>'api.v1.'],
    function ()
    {
        Route::post("/company/list",[\App\Http\Controllers\APIs\CompanyController::class,"companyList"])->name('company.list');
        Route::post("/company/create",[\App\Http\Controllers\APIs\CompanyController::class,"companyCreate"])->name('company.create');
        Route::post("/company/view/edit",[\App\Http\Controllers\APIs\CompanyController::class,"companyViewEdit"])->name('company.view.edit');
        Route::post("/company/edit",[\App\Http\Controllers\APIs\CompanyController::class,"companyEdit"])->name('company.edit');
        Route::post("/company/delete",[\App\Http\Controllers\APIs\CompanyController::class,"companyDelete"])->name('company.delete');
    });
