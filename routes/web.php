<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TaskController::class, 'index'])->name('home');

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/create', [TaskController::class, 'create'])->name('create.task');
    Route::post('/create', [TaskController::class, 'store'])->name('store.task');
    Route::get('/edit/{task}', [TaskController::class, 'edit'])->name('edit.task');
    Route::put('/update/{task}', [TaskController::class, 'update'])->name('update.task');
    Route::delete('/delete/{task}', [TaskController::class, 'destroy'])->name('delete.task');
    Route::post('/order/save', [TaskController::class, 'tasks_order'])->name('save.order.task');
});
