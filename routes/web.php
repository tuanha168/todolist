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

Route::get('/', [App\Http\Controllers\TodoListController::class, 'index'])->name('task.show');
Route::post('/', [App\Http\Controllers\TodoListController::class, 'create'])->name('task.store');
Route::put('/', [App\Http\Controllers\TodoListController::class, 'update'])->name('task.update');
Route::delete('/', [App\Http\Controllers\TodoListController::class, 'delete'])->name('task.delete');
