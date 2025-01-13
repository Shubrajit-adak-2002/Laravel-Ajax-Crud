<?php

use App\Http\Controllers\CRUDController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('form');
});

# This are ajax crud routes

Route::post('submit',[CRUDController::class,'submit'])->name('submit');
Route::get('show',[CRUDController::class,'display']);
Route::get('display',[CRUDController::class,'getStudents'])->name('student.display');
Route::get('edit-student/{id}',[CRUDController::class,'edit_student']);
Route::post('update-student',[CRUDController::class,'update_student'])->name('student.update');
Route::get('delete-student/{id}',[CRUDController::class,'delete_student']);

# This is search route
Route::get('search',[SearchController::class,'search'])->name('search');
