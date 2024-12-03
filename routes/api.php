<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('employee', [\App\Http\Controllers\EmployeeController::class, 'index'])->middleware('role:manajer|karyawan');
    Route::get('employee/{user}', [\App\Http\Controllers\EmployeeController::class, 'show'])->middleware('role:manajer');
    Route::post('employee', [\App\Http\Controllers\EmployeeController::class, 'store'])->middleware('role:manajer');
    Route::put('employee/{user}', [\App\Http\Controllers\EmployeeController::class, 'update'])->middleware('role:manajer');
    Route::delete('employee/{user}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->middleware('role:manajer');

    Route::post('companies', [\App\Http\Controllers\CompanyController::class, 'store'])->middleware('role:superadmin');
});
