<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
      return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
      Route::resource('project', ProjectController::class);
      Route::resource('task', TaskController::class);


      Route::get('project/complete/{id}', [ProjectController::class, 'complete'])->name('project.completed');

      Route::get('project/delete/{id}', [ProjectController::class, 'delete'])->name('project.delete');

      Route::get('task/delete/{id}', [TaskController::class, 'destroy'])->name('task.delete');

      Route::get('task/edit/{id}', [TaskController::class, 'edit_page'])->name('task.edit_page');

      Route::get('task/complete/{id}', [TaskController::class, 'update_status'])->name('task.done');

      Route::get('task/not/complete/{id}', [TaskController::class, 'not_done'])->name('task.not_done');
});

Route::middleware('auth')->group(function () {
      Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
      Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
      Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';