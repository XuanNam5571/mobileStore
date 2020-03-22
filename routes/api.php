<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'admin'],function(){
	Route::resource('category','CategoryController');
	Route::resource('producttype','ProductTypeController');
	Route::resource('product','ProductController');
	Route::post('updatePro/{id}','ProductController@update');
});
Route::get('getindex',function(){
	return view('client.pages.index');
});

//Dang nhap vs dang ki
Route::post('login','UserController@loginClient')->name('login');
Route::post('register','UserController@register')->name('register');
Route::get('logout','UserController@logout')->name('logout');

//lay danh sach san pham va loai san pham
Route::resource('cart','CartController');
Route::get('getCart','CartController@getCart');
Route::get('addcart/{id}','CartController@addCart')->name('addCart');
Route::get('checkout','CartController@checkout')->name('checkout');

Route::resource('customer','CustomerController');