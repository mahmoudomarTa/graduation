<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'auth:api'], function () {

////////////////////////////////  UserController   ///////////////////////////////////
    Route::post('/editUserProfile', 'API\v1\UserController@editUserProfile');
    Route::post('/changePassword', 'API\v1\UserController@changePassword');
    Route::get('/MyProfile', 'API\v1\UserController@MyProfile');
    Route::post('/sendMessage', 'API\UserController@sendMessage');
    Route::get('/getMyMessages', 'API\UserController@getMyMessages');
    Route::get('/logout', 'API\v1\UserController@logout');
    Route::post('/receiveNotification', 'API\v1\UserController@receiveNotification');



    Route::get('myNotifications', 'API\v1\UserController@myNotifications');

    Route::get('getMyAddresses', 'API\v1\UserController@getMyAddresses');
    Route::post('addAddress', 'API\v1\UserController@addAddress');
    Route::get('deleteAddress/{id}', 'API\v1\UserController@deleteAddress');
    Route::post('/editAddress/{id}', 'API\v1\UserController@editAddress');


});

 ////////////////////////////////  AppController   ///////////////////////////////////
Route::get('getSetting', 'API\v1\AppController@getSetting');
Route::post('updateMyLanguage', 'API\v1\AppController@updateMyLanguage');
Route::get('getFaqs', 'API\v1\AppController@getFaqs');
Route::get('pages/{id}', 'API\v1\AppController@pages');
Route::post('contactUs', 'API\v1\AppController@contactUs');
Route::get('getAges', 'API\v1\AppController@getAges');
Route::get('filter', 'API\v1\AppController@filter');
Route::get('search', 'API\v1\AppController@search');
Route::get('testPay', 'API\AppController@testPay');

Route::get('getVehicleCategories', 'API\v1\AppController@getVehicleCategories');
 Route::get('getVehicleTypes/{id}', 'API\v1\AppController@getVehicleTypes');
Route::get('getAreas', 'API\v1\AppController@getAreas');



////////////////////////////////  UserController   ///////////////////////////////////

Route::post('/login', 'API\v1\UserController@login');
Route::post('/signUp', 'API\v1\UserController@signUp');
Route::post('/forgotPassword', 'API\v1\UserController@forgotPassword');

 
