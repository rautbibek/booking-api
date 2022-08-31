<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingTypeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
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
        Route::get('/',[UserController::class,'index'])->middleware('permission:view user');
        Route::post('/{id}/role',[UserController::class,'setUserRolePermission'])->middleware('permission:edit role');
        Route::get('/{id}/setting',[UserController::class,'userSetting'])->middleware('permission:edit user');
    });
    
    //role group
    Route::group(['prefix'=>'role'], function(){
        Route::get('/',[RoleController::class,'index'])->middleware('permission:view role');
        Route::get('/all',[RoleController::class,'roles']);
        Route::get('/{id}',[RoleController::class,'view'])->middleware('permission:edit role');
        Route::post('/store',[RoleController::class,'store'])->middleware('permission:create role');
        Route::delete('/{id}/delete',[RoleController::class,'delete'])->middleware('permission:alter role');
    });

    // permission group
    Route::group(['prefix'=>'permission'], function(){
        Route::get('/',[PermissionController::class,'index'])->middleware('permission:view permission');
        Route::post('/store',[PermissionController::class,'store'])->middleware('permission:create permission');
        Route::delete('/{id}/delete',[PermissionController::class,'delete'])->middleware('permission:alter permission');
        Route::get('/all',[PermissionController::class,'getAllPermissions']);
    });

    // booking
    Route::group(['prefix'=>'booking'], function(){
        Route::get('/type',[BookingTypeController::class,'index'])->middleware('permission:view booking type');
    });
    Route::group(['prefix'=>'service'], function(){
        Route::get('/',[ServiceController::class,'index'])->middleware('permission:view all service');
        Route::get('/my-service',[ServiceController::class,'myService'])->middleware('permission:view service');
        Route::get('/{id}/edit',[ServiceController::class,'edit'])->middleware('permission:edit service');
        Route::post('/store',[ServiceController::class,'store'])->middleware('permission:create service');
        Route::delete('/{id}/delete',[ServiceController::class,'delete'])->middleware('permission:alter service');
        Route::post('/{id}/update',[ServiceController::class,'update'])->middleware('permission:edit service');
        Route::put('/{id}/status',[ServiceController::class,'changeStatus'])->middleware('permission:alter service');
    });


    Route::group(['prefix'=>'business'], function(){
        Route::get('/',[BusinessController::class,'index'])->middleware('permission:view business');
        Route::get('/my-business',[BusinessController::class,'myBusiness'])->middleware('permission:view business');
        Route::get('/detail/{id}',[BusinessController::class,'businessDetail'])->middleware('permission:view business');
        Route::get('/{id}/edit',[BusinessController::class,'edit'])->middleware('permission:edit business');
        Route::post('/store',[BusinessController::class,'store'])->middleware('permission:create business');
        Route::delete('/{id}/delete',[BusinessController::class,'delete'])->middleware('permission:alter business');
        Route::post('/{id}/update',[BusinessController::class,'update'])->middleware('permission:edit business');
        Route::put('/{id}/status',[BusinessController::class,'changeStatus'])->middleware('permission:alter business');
    });

    // category
    Route::group(['prefix'=>'category'], function(){
        Route::get('/',[CategoryController::class,'index']);
        Route::get('{id}/detail',[CategoryController::class,'show']);
        Route::post('/store',[CategoryController::class,'store']);
        Route::put('{id}/status',[CategoryController::class,'changeStatus']);
        Route::delete('{id}/delete',[CategoryController::class,'delete']);
        Route::get('/all',[CategoryController::class,'getAllCategory']);
    });

    Route::post('/media',[MediaController::class,'medaiValidator']);
    Route::post('logout',[LoginController::class,'logout']);
});
