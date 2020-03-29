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
Route::get('getindex','HomeController@index');

//Dang nhap vs dang ki
Route::post('login','UserController@loginClient')->name('login');
Route::post('register','UserController@register')->name('register');
Route::get('logout','UserController@logout')->name('logout');
//Dang nhap danh cho Admin
Route::post('admin/login','UserController@loginAdmin')->name('admin.login');
Route::view('admin/login','admin.pages.login')->name('login.admin');
//lay danh sach san pham va loai san pham
Route::resource('cart','CartController');
Route::get('getCart','CartController@getCart');
Route::get('addcart/{id}','CartController@addCart')->name('addCart');
Route::get('checkout','CartController@checkout')->name('checkout');

Route::resource('customer','CustomerController');