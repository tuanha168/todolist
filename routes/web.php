<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [AccountController::class, 'create'])->name('account.store');
Route::put('/', [AccountController::class, 'update'])->name('account.update');
Route::post('/transfer', [TransactionController::class, 'create'])->name('transaction.store');
Route::post('/transfer/confirm', [TransactionController::class, 'confirm'])->name('transaction.confirm');
Route::get('/transaction/{id}/{limit?}', [TransactionController::class, 'show'])->name('transaction.show');

Route::get('/profiles', [ProfilesController::class, 'show'])->name('profiles.show');
Route::put('/profiles', [ProfilesController::class, 'update'])->name('profiles.update');
