<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\TokensController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('login', [UserController::class, 'login']);
// Route::post('register', [UserController::class, 'register']);

// Route::group(['middleware' => ["auth:sanctum"]], function(){
//     Route::get('profile', [UserController::class, 'profile']);
//     Route::get('logout', [UserController::class, 'logout']);

// });

Route::post('/v1/login', [TokensController::class, 'authenticate']);
Route::post('/v1/register', [TokensController::class, 'register']);

Route::group(['middleware' => ['jwt.verify'],  'prefix' => 'v1'], function() {
    Route::post('user',[TokensController::class, 'getAuthenticatedUser']);
    Route::get('/logout', [TokensController::class, 'logout']);
    Route::post('/refresh', [TokensController::class, 'refresh']);
    Route::post('/profile', [TokensController::class, 'profile']);
    Route::apiResources([
        'empresas' => 'Api\CompanyController'
        ]);

});


