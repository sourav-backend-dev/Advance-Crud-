<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/register', function () {
    return view('register');
});
Route::get('/img', function () {
    return view('img');
});
Route::post('register',[UserController::class,'register'])->name("reg");
Route::get('display', [UserController::class, 'display']);
Route::get('/', [UserController::class, 'index'])->name("index");
Route::get('edit/{id}', [UserController::class, 'edit']);
Route::put('update/{id}', [UserController::class, 'update']);
Route::get('delete/{id}', [UserController::class, 'delete']);

// ajax routing 
Route::get('ajaxindex', [ProjectController::class, 'ajaxindex'])->name("ajaxindex");
Route::get('ajaxindex/{page}', [ProjectController::class, 'pagination'])->name("projects.pagination");
Route::resource('projects', ProjectController::class);
Route::delete('projects/{id}', 'ProjectController@destroy')->name('projects.destroy');
Route::get('search', [ProjectController::class, 'search'])->name('projects.search');
Route::get('edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::post('update', [ProjectController::class, 'update'])->name('projects.update');
// Route::get('sort/{page}', [ProjectController::class, 'sort'])->name('projects.sort');
Route::get('filters', [ProjectController::class, 'filters'])->name('projects.filters');