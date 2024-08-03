<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgetPasswordController;
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
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});
Route::group(['prefix'=>'handle-password'], function () {
    Route::get('/forget', [ForgetPasswordController::class, 'forgetPassword'])->name('forget.password');
    Route::post('/forget', [ForgetPasswordController::class, 'forgetPasswordPost'])->name('forget.password.post');
    Route::get('/reset/{token}', [ForgetPasswordController::class, 'resetPassword'])->name('reset.password');
    Route::post('/reset', [ForgetPasswordController::class, 'resetPasswordPost'])->name('reset.password.post');

});

Route::group(['prefix'=>'todos'], function (){
    Route::get('/',[TodoController::class, 'index'])->name('todo.index');
    Route::get('/create',[TodoController::class, 'create'])->name('todo.create')->middleware('auth');
    Route::get('/{todo}',[TodoController::class, 'show'])->name('todo.show');
    Route::get('/{todo}/completed',[TodoController::class, 'completed'])->name('todo.completed')->middleware('auth');
    Route::post('/store',[TodoController::class, 'store'])->name('todo.store')->middleware('auth');
    Route::get('/{todo}/edit',[TodoController::class, 'edit'])->name('todo.edit')->middleware('auth');
    Route::put('/{todo}', [TodoController::class, 'update'])->name('todo.update')->middleware('auth');
    Route::delete('/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy')->middleware('auth');
    
});

Route::group(['prefix'=>'categories', 'middleware' => 'auth'], function (){
    Route::get('/',[CategoryController::class, 'index'])->name('category.index');
    Route::get('/create',[CategoryController::class, 'create'])->name('category.create');
    Route::post('/store',[CategoryController::class, 'store'])->name('category.store');
    Route::get('/{category}/edit',[CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});