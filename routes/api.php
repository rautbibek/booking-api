<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::post('login',[LoginController::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::get('user',[UserController::class,'index']);
    Route::get('role',[RoleController::class,'index']);
    Route::get('permission',[RoleController::class,'permissions']);
    Route::get('/all/permissions',[RoleController::class,'getAllPermissions']);
    Route::post('logout',[LoginController::class,'logout']);
});
