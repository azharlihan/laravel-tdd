<?php

use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks', [TasksController::class, 'index']);
Route::post('tasks', [TasksController::class, 'store']);
Route::patch('tasks/{task}', [TasksController::class, 'update']);
Route::delete('tasks/{task}', [TasksController::class, 'destroy']);
Route::patch('tasks/{task}/toggle', [TasksController::class, 'toggle']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
