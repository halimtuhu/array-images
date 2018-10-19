<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Halimtuhu\ArrayImages\Http\Controllers\ArrayImagesController@index');
Route::post('/upload', 'Halimtuhu\ArrayImages\Http\Controllers\ArrayImagesController@upload');
Route::delete('/delete/{image}', 'Halimtuhu\ArrayImages\Http\Controllers\ArrayImagesController@delete');
