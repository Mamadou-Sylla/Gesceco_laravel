<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CantineController;
use App\Http\Controllers\FactureController;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group( function(){
Route::resource('/admin', 'App\Http\Controllers\AdminController');
Route::apiResource('/role', 'App\Http\Controllers\RoleController');
Route::apiResource('/facture', 'App\Http\Controllers\FactureController');
});
Route::apiResource('/cantine', 'App\Http\Controllers\CantineController');
Route::resource('/user', 'App\Http\Controllers\UserController');
Route::resource('/client', 'App\Http\Controllers\ClientController');
