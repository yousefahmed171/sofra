<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('admin.index');
    //return redirect()->to('admin');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth' , 'prefix' => 'admin'],function(){
    Route::get('/','HomeController@index');
    Route::resource('city', 'CityController');
    Route::resource('region', 'RegionController');
    Route::resource('category', 'CategoryController');
    Route::resource('offer', 'OfferController');
    Route::get('restaurant/{id}/activate', 'RestaurantController@activate');
    Route::get('restaurant/{id}/de-activate', 'RestaurantController@deActivate');
    Route::resource('restaurant','RestaurantController');
    Route::resource('{restaurant}/item', 'ItemController');
    Route::resource('order','OrderController');
    Route::resource('transaction','TransactionController');
    Route::resource('payment-method','PaymentMethodController');
    Route::resource('delivery-method','DeliveryMethodController');
    Route::resource('contact','ContactController');
    Route::resource('client','ClientController');

    Route::get('settings','SettingsController@view');
    Route::post('settings','SettingsController@update');
    
    // user reset
    Route::get('user/change-password','UserController@changePassword');
    Route::post('user/change-password','UserController@changePasswordSave');
//    Route::resource('user','UserController');
//    Route::resource('role','RoleController');
});
