<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Halimtuhu\ArrayImages\FieldController@index');
Route::post('/upload', 'Halimtuhu\ArrayImages\FieldController@upload');
Route::delete('/delete/{saved_path}', 'Halimtuhu\ArrayImages\FieldController@delete')
    ->where('saved_path', '(.*)');
