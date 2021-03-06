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
// Groups
Route::group(['domain'=>'checkout.gauzymall.bs2'],function(){
    Route::controller('/', 'CheckoutController');
});
Route::group(['domain'=>'checkout.gauzymall.com'],function(){
    Route::controller('/', 'CheckoutController');
});
Route::group(['domain'=>'manager.gauzymall.com'],function(){
    Route::controller('/', 'ManagerController');
});
Route::group(['domain'=>'manager.gauzymall.bs2'],function(){
    Route::controller('/', 'ManagerController');
});
Route::group(['domain'=>'cart.gauzymall.bs2'],function(){
    Route::controller('/', 'CartController');
});
Route::group(['domain'=>'cart.gauzymall.com'],function(){
    Route::controller('/', 'CartController');
});
Route::group(['domain'=>'dictionary.gauzymall.com'],function(){
    Route::controller('/', 'DictionaryController');
});
Route::group(['domain'=>'dictionary.gauzymall.bs2'],function(){
    Route::controller('/', 'DictionaryController');
});

// Old style
Route::controller('gcat', 'GCatController');
Route::controller('xray', 'GreenLineController');
Route::resource('customer', 'GaranCustomerController');
Route::resource('order', 'GaranOrderController');
Route::resource('product', 'GaranProductController');
Route::controller('prod', 'ProductsController');
Route::controller('store', 'CopierController');
Route::controller('magnitolkin', 'MagnitolkinController');
Route::controller('democheckout', 'DemoCheckoutController');
Route::controller('checkout', 'CheckoutOldController');
Route::controller('mail', 'MailController');
Route::controller('my', 'MyController');
Route::controller('cart', 'CartController');
//Route::controller('manager', 'ManagerController');
Route::match(['get','post'],'/shipping/bb', 'ServicesController@ShippingBoxberry');
Route::match(['get','post'],'/statuses', 'ServicesController@Statuses');
Route::match(['get','post'],'/statuses/{wc_status}', 'ServicesController@StatusByWC');
Route::match(['get','post'],'/crd', 'ServicesController@CrossDomain');
Route::match(['get','post'],'/calculator', 'ServicesController@CalculatorDomain');
Route::match(['get','post'],'/currency', 'ServicesController@Currency');
Route::match(['get','post'],'/currency/update', 'ManagerController@CurrencyUpdate');
Route::match(['get','post'],'/social', 'ServicesController@Social');
Route::match(['get','post'],'/analytics', 'ServicesController@Analytics');
Route::match(['post'],'/error', 'ServicesController@CatchExceptions');

Route::auth();

Route::get('/home', 'HomeController@index');


// Default controller
Route::controller('/', 'WebController');
