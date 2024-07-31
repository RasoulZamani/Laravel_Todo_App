<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TodoController::class, 'index'])->name('todo.index');

Route::prefix('categories')->group(function (){
    Route::get('/create',[CategoryController::class, 'create'])->name('category.create');
    Route::post('/store',[CategoryController::class, 'store'])->name('category.store');

});