<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks/search', [TaskController::class, 'search'])
    ->name('tasks.search');
Route::get('/', [TaskController::class, 'index'])
    ->name('tasks.index');
Route::get('/tasks/all', [TaskController::class, 'allTasks'])
    ->name('tasks.all');
Route::get('/tasks/create', [TaskController::class, 'create'])
    ->name('tasks.create');

Route::post('/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');

Route::get('/tasks/{task}', [TaskController::class, 'show'])
    ->name('tasks.show');

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
    ->name('tasks.edit');

Route::put('/tasks/{task}', [TaskController::class, 'update'])
    ->name('tasks.update');

Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])
    ->name('tasks.destroy');

Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
    ->name('tasks.updateStatus');