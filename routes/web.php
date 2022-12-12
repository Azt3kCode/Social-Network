<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControlController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/control', [App\Http\Controllers\ControlController::class, 'index'])->name('control');
Route::post('/control/send/{id}', [App\Http\Controllers\ControlController::class, 'store'])->name('control.store');
Route::post('/control/accept/{id}', [App\Http\Controllers\ControlController::class, 'update'])->name('control.update');
Route::delete('/control/delete/{id}', [App\Http\Controllers\ControlController::class, 'destroy'])->name('control.delete');

Route::get('/chat', [App\Http\Controllers\FriendRequestController::class, 'index'])->name('chat');
Route::get('/chat/{id}', [App\Http\Controllers\FriendRequestController::class, 'show'])->name('chat.show');
Route::post('/chat/{id}', [App\Http\Controllers\ChatController::class, 'create'])->name('chat.create');