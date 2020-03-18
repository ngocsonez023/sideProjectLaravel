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

Route::post('login', 'Api\UserController@login');

Route::group(['middleware' => ['jwt.verify']], function () { 
	Route::post('logout', 'Api\UserController@logout'); 

	Route::post('category', 'Api\CategoryController@category');
	Route::post('category/add', 'Api\CategoryController@add');
	Route::post('category/edit/{id}', 'Api\CategoryController@edit');
	Route::post('category/delete/{id}', 'Api\CategoryController@delete');

	Route::post('coupon', 'Api\CouponController@coupon');
	Route::post('coupon/add', 'Api\CouponController@add');
	Route::post('coupon/edit/{id}', 'Api\CouponController@edit');
	Route::post('coupon/delete/{id}', 'Api\CouponController@delete');

	Route::post('order', 'Api\OrderController@order');
	Route::post('order/view/{id}', 'Api\OrderController@view');
	Route::post('order/update/{id}', 'Api\OrderController@update');
	Route::post('order/delete/{id}', 'Api\OrderController@delete');

	Route::post('product', 'Api\ProductController@product');
	Route::post('product/add', 'Api\ProductController@add');
	Route::post('product/edit/{id}', 'Api\ProductController@edit');
	Route::post('product/delete/{id}', 'Api\ProductController@delete');
});


