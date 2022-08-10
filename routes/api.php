<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
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
    Route::get('/auth/user',[UserController::class,'authUser']);
    Route::group(['prefix'=>'user'], function(){
        Route::get('/',[UserController::class,'index']);
        Route::post('/{id}/role',[UserController::class,'setUserRolePermission']);
        Route::get('/{id}/setting',[UserController::class,'userSetting']);
    });
    

    //role group
    Route::group(['prefix'=>'role'], function(){
        Route::get('/',[RoleController::class,'index']);
        Route::get('/all',[RoleController::class,'roles']);
        Route::get('/{id}',[RoleController::class,'view']);
        Route::post('/store',[RoleController::class,'store']);
        Route::delete('/{id}/delete',[RoleController::class,'delete']);
    });

    // permission group
    Route::group(['prefix'=>'permission'], function(){
        Route::get('/',[PermissionController::class,'index']);
        Route::post('/store',[PermissionController::class,'store']);
        Route::delete('/{id}/delete',[PermissionController::class,'delete']);
        Route::get('/all',[PermissionController::class,'getAllPermissions']);
    });

    Route::post('logout',[LoginController::class,'logout']);
});
