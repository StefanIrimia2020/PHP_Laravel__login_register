<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'uses' => 'UsersController@home',
    'as' => 'home',
]);

Route::get('/login', [
    'uses' => 'UsersController@login',
    'as' => 'user.login'
]);

Route::post('/login/validate', [
    'uses' => 'UsersController@validateLogin',
    'as' => 'user.validate'
]);

Route::get('/create', [
    'uses' => 'UsersController@create',
    'as' => 'user.create'
]);

Route::post('/user/store', [
    'uses' => 'UsersController@store',
    'as' => 'user.store'
]);

Route::get('/user/verify/{token}', [
    'uses' => 'UsersController@verifyEmail',
    'as' => 'user.verify',
]);

Route::get('/ajax', [UsersController::class,'index']);

Route::get('/user/all', [UsersController::class,'allData']);

Route::get('/user/edit/{id}', [UsersController::class,'editData']);

Route::post('/user/update/', [UsersController::class,'updateData']);

Route::get('dashboard', [UsersController::class,'lista']);
Route::get('terms', [UsersController::class,'term_cond']);

Route::get('deleteU/{id}', [UsersController::class,'deleteUser']);
Route::get('edit/{id}', [UsersController::class,'editUser']);
Route::post('edit', [UsersController::class,'updateUser']);

//Route::get('/log_out', [UsersController::class,'log_out']);