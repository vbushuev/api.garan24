<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {return view('welcome');});

Route::resource('customer', 'GaranCustomerController');
Route::resource('order', 'GaranOrderController');
Route::resource('product', 'GaranProductController');
Route::controller('magnitolkin', 'MagnitolkinController');
Route::controller('democheckout', 'DemoCheckoutController');
Route::controller('checkout', 'CheckoutController');
Route::controller('mail', 'MailController');
Route::match(['get','post'],'/shipping/bb', 'ServicesController@ShippingBoxberry');
Route::match(['get','post'],'/statuses', 'ServicesController@Statuses');
Route::match(['get','post'],'/statuses/{wc_status}', 'ServicesController@StatusByWC');
Route::match(['get','post'],'/crd', 'ServicesController@CrossDomain');
Route::controller('/', 'WebController');
