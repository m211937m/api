<?php

use App\Http\Controllers\api\CategorisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthUserController;
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


Route::group(['middleware'=>['api','checkpassword','changelanguage']],function(){
    Route::post('get-main-categories',[CategorisController::class,'index']);
    Route::post('get-category-byId',[CategorisController::class,'getcategorybyId']);
    Route::post('get-category-status',[CategorisController::class,'changeystatus']);
    Route::group(['prefix' => 'admin'],function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('logout',[AuthController::class,'logout'])->middleware('AsslgnGuard:admin-api');
    });
    Route::group(['prefix' => 'user'],function(){
        Route::post('login',[AuthUserController::class,'login']);
    });
Route::group(['prefix' => 'user','middleware'=> ['AsslgnGuard:user-api']],function(){
        Route::post('profile',function(){
            return App\Models\User::get();
        });
    });
});

