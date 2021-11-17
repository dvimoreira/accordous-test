<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\PropertiesController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'

], function ($router) {
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/auth/refresh-token', [AuthController::class, 'refresh'])->name('refreshToken');
    Route::get('/auth/user-profile', [AuthController::class, 'userProfile'])->name('profile');
    
    // PROPERTIES
    Route::get('/properties/list', [PropertiesController::class, 'index'])->name('properties.list');
    Route::get('/properties/listById/{id}', [PropertiesController::class, 'listById'])->name('properties.listById');
    Route::post('/properties/create', [PropertiesController::class, 'create'])->name('properties.create');
    Route::post('/properties/edit', [PropertiesController::class, 'edit'])->name('properties.edit');
    Route::get('/properties/destroy/{id}', [PropertiesController::class, 'destroy'])->name('properties.destroy');

    // CONTRACTS
    Route::get('/contracts/list', [ContractsController::class, 'index'])->name('contracts.list');
    Route::get('/contracts/listById/{id}', [ContractsController::class, 'listById'])->name('contracts.listById');
    Route::post('/contracts/create', [ContractsController::class, 'create'])->name('contracts.create');
    Route::post('/contracts/edit', [ContractsController::class, 'edit'])->name('contracts.edit');
    Route::get('/contracts/destroy/{id}', [ContractsController::class, 'destroy'])->name('contracts.destroy');
});
