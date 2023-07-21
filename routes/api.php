<?php

use App\Http\Controllers\AuthController;
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

$basePathController = 'App\Http\Controllers\\';

Route::prefix('auth')->group(function (){
    Route::post('sign-in', [AuthController::class, 'signIn'])->name('auth.sign-in');
    Route::post('check-auth', [AuthController::class, 'checkAuth'])->name('auth.check-auth')->middleware(['api_access']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('passwords.sent');
    Route::post('check-password-reset-token', [AuthController::class, 'checkPasswordResetToken']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::get('check-log', 'App\Http\Controllers\AppsController@checkLog');



    Route::get('hola-mundo', 'App\Http\Controllers\AppsController@buildApp');

    // Route::get('apps/get-all', 'App\Http\Controllers\AppsController@getAll');
    // Route::get('apps/create', 'App\Http\Controllers\AppsController@store');
    // Route::get('apps/abort-creation', 'App\Http\Controllers\AppsController@abort');

	Route::resource('apps', 'App\Http\Controllers\AppsController');

    Route::get('test', 'App\Http\Controllers\TestController@index');

    Route::get('get-options-for-select', 'App\Http\Controllers\GlobalController@getOptionsForSelect');

    Route::get('check-log', 'App\Http\Controllers\GlobalController@checkLog');

    Route::resource('entities', 'App\Http\Controllers\EntitiesController');
    Route::get('get-entity/{id}', 'App\Http\Controllers\EntitiesController@getEntity');
    Route::get('delete-field/{id}', 'App\Http\Controllers\EntitiesController@deleteField');
    Route::delete('step/{id}', 'App\Http\Controllers\EntitiesController@deleteStep');


	/* Add new routes here */
