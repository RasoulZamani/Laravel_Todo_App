<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', [TodoController::class, 'index'])->name('home');
Route::prefix('users')->group(function (){
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
});
Route::prefix('todos')->group(function (){
    Route::get('/',[TodoController::class, 'index'])->name('todo.index');
    Route::get('/create',[TodoController::class, 'create'])->name('todo.create');
    Route::get('/{todo}',[TodoController::class, 'show'])->name('todo.show');
    Route::get('/{todo}/completed',[TodoController::class, 'completed'])->name('todo.completed');
    Route::post('/store',[TodoController::class, 'store'])->name('todo.store');
    Route::get('/{todo}/edit',[TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/{todo}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
    
});

Route::prefix('categories')->group(function (){
    Route::get('/',[CategoryController::class, 'index'])->name('category.index');
    Route::get('/create',[CategoryController::class, 'create'])->name('category.create');
    Route::post('/store',[CategoryController::class, 'store'])->name('category.store');
    Route::get('/{category}/edit',[CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    
});