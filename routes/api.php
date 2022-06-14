<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\TokensController;
use Illuminate\Support\Facades\Route;


Route::post('/v1/login', [TokensController::class, 'authenticate']);
Route::post('/v1/register', [TokensController::class, 'register']);

Route::group(['middleware' => ['jwt.verify', 'api'],  'prefix' => 'v1'], function() {
    Route::post('/profile', [TokensController::class, 'profile']);
    Route::post('user',[TokensController::class, 'getAuthenticatedUser']);
    Route::get('/logout', [TokensController::class, 'logout']);

    Route::apiResources([
        '/empresas' => 'Api\CompanyController',
        '/usuarios' => 'Api\UserController',
        '/search' => 'Api\SearchController'
        ]);

    // Route::get('empresas/search', [CompanyController::class, 'search'])->name('empresas.search');
});



