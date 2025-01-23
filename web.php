<?php

use App\Http\Controllers\Mycontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('form');
});

Route::post('submit',[Mycontroller::class,'submit'])->name('submit');
Route::view('show','display')->name('table');
Route::get('display',[Mycontroller::class,'display'])->name('display');
Route::get('edit/{id}',[Mycontroller::class,'edit'])->name('edit');
Route::post('update/{id}',[Mycontroller::class,'update'])->name('update');
Route::post('delete/{id}',[Mycontroller::class,'delete'])->name('delete');
