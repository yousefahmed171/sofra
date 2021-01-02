<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
    return view('welcome');
    //return redirect()->to('admin');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Admin
Route::group(['prefix' => 'admin', 'namespace'=> 'Admin'],function(){

    Config::set('auth.defines', 'admin'); //set guards
    Route::get('login', 'AdminAuthController@login');
    Route::post('login', 'AdminAuthController@doLogin');
    Route::get('register', 'AdminAuthController@register');
    Route::post('register', 'AdminAuthController@doRegister');

    Route::get('forget/password', 'AdminAuthController@forget_password');
    Route::post('forget/password', 'AdminAuthController@forget_password_post');
    Route::get('reset/password/{token}', 'AdminAuthController@reset_password');
    Route::post('reset/password/{token}', 'AdminAuthController@reset_password_final');

    Route::group(['middleware' => 'admin:admin'], function(){

        // AdminAuthController
        Route::any('logout', 'AdminAuthController@logout');


        // AdminMainController
        Route::get('home', 'AdminMainController@index');
        Route::resource('categories', 'CategoryController');
        Route::resource('cities', 'CityController');
        Route::resource('regions', 'RegionController'); 
        Route::resource('contacts', 'ContactController');
        Route::resource('settings', 'SettingController');
        Route::resource('clients','ClientController');
        Route::put('de-active/{id}', 'ClientController@deActive');
        Route::put('active/{id}', 'ClientController@active');
        Route::resource('restaurants','RestaurantController');
        Route::put('de-active/{id}', 'RestaurantController@deActive');
        Route::put('active/{id}', 'RestaurantController@active');
        Route::resource('offers','OfferController');
        Route::resource('orders','OrderController');
        Route::resource('admins', 'AdminController');
        Route::resource('roles', 'RoleController');
        Route::resource('reset-password', 'ResetPaswwordController');

    });


});
