<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/store', [AuthController::class, 'store']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
Route::get('/', [TodoController::class, 'index'])->name('todos.index');
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

Route::get('/dashboard', function () {
    $user = auth()->user();
    $total = \App\Models\Todo::count();
    $completed = \App\Models\Todo::where('completed', true)->count();
    $active = \App\Models\Todo::where('completed', false)->count();

    return view('dashboard', compact('user', 'total', 'completed', 'active'));
})->name('dashboard');

});
