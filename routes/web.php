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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::middleware("auth")->group(function () {
	Route::get('/dashboard', 'MainController@index')->name('dashboard');
	Route::post('/addStatus', 'StatusController@addStatus');
	Route::post('/addCategory', 'CategoryController@addCategory');
	Route::post('/addAuthor', 'AuthorController@addAuthor');
	Route::post('/addAsset', 'BookController@addAsset');
	Route::patch('/updateStatus', 'StatusController@updateStatus');
	Route::delete('/deleteStatus/{id}', 'StatusController@deleteStatus');
	Route::patch('/updateAsset', 'BookController@updateAsset');
	Route::delete('/deleteAsset/{id}', 'BookController@deleteAsset');
	Route::patch('/updateCategory', 'CategoryController@updateCategory');
	Route::delete('/deleteCategory/{id}', 'CategoryController@deleteCategory');
	Route::patch('/updateAuthor', 'AuthorController@updateAuthor');
	Route::delete('/deleteAuthor/{id}', 'AuthorController@deleteAuthor');

	Route::get('/byCategory/{id}', 'CategoryController@showCategory');

	Route::patch('/user/makeAdmin', 'AdminController@makeAdmin');
	Route::patch('/user/removeAdmin', 'AdminController@removeAdmin');

	Route::post('/book/borrow', 'TransactionController@bookBorrow');
	Route::patch('/book/return', 'TransactionController@bookReturn');
	Route::patch('/transaction/approve', 'TransactionController@approveRequest');
});

Route::get('/test', 'HomeController@test');