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

// Route::get('/', function () {
//     return view('admin.pages.index');
// });
// Route::get('getproducttype','AjaxController@getProductType');
Route::group(['prefix'=>'admin'],function(){
	Route::resource('category','CategoryController');
	Route::resource('producttype','ProductTypeController');
	Route::resource('product','ProductController');
	Route::post('updatePro/{id}','ProductController@update');
});
// Route::get('getindex','HomeController@index');
// // Route::post('login','UserController@loginClient')->name('login');
// // Route::post('register','UserController@register')->name('register');
// // Route::get('logout','UserController@logout')->name('logout');

// Route::resource('cart','CartController');
// Route::get('addcart/{id}','CartController@addCart')->name('addCart');