<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
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

Route::post('/v1/register', [AuthController::class, 'register'])->name('register');
Route::post('/v1/login', [AuthController::class, 'login'])->name('login');
Route::get('/v1/totalusers', [UserController::class, 'totalusers'])->name('total users');
Route::get('/v1/getallwallet', [WalletController::class, 'getAllWallet'])->name('get all wallet');
Route::get('/v1/getwalletdetails/{id}', [WalletController::class, 'getWalletDetails'])->name('get wallet details');


Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::get('/v1/getuser/{id}', [UserController::class, 'getUserDetails'])->name('get user details');
});
