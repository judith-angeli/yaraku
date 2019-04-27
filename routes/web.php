<?php

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

Route::get('books/search/{search?}/sort/{sort?}', 'BookController@search')
    ->name('books.search');

Route::get('books/export/{export}/file/{file}/sort/{sort?}/search/{search?}', 'BookController@export')
    ->name('books.export');


Route::resource('books', 'BookController');
Route::resource('authors', 'AuthorController');
