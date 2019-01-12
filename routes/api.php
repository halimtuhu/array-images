<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Halimtuhu\ArrayImages\FieldController@index');
Route::post('/upload', 'Halimtuhu\ArrayImages\FieldController@upload');
Route::delete('/delete/{image}', 'Halimtuhu\ArrayImages\FieldController@delete');
