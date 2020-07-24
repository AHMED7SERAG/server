<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
        Route::group(['middleware' => 'api','prefix' =>'admin','namespace'=>'Api\Admin\Auth'], function () {
            Route::post('login', 'LoginController@login');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
            Route::post('password/reset', 'ResetPasswordController@reset');
            Route::post('email/resend','VerificationController@resend' );
            Route::get('email/verify/{id}/{hash}', 'VerificationController@verify');
        });
        Route::group(['middleware' => 'auth:admins','prefix' =>'admin','namespace'=>'Api\Admin'], function () {
         
         Route::group(['prefix' => 'Auth'], function () {
            Route::post('logout', 'LoginController@logout');
            Route::post('refresh', 'LoginController@refresh');
            Route::post('me',  'LoginController@me');
         });   

            // admin editing and create new admin , delete ,update profile
            Route::post('getAdmins', 'AdminController@getAdmins');
            Route::post('addAdmin', 'AdminController@store');
            Route::post('updateAdmin', 'AdminController@update');
            Route::post('destroyAdmin', 'AdminController@destroy');

            // admin editing and create new cities , delete ,update 
            Route::group(['prefix' => 'cities'], function () {
                Route::post('getAllCities', 'CityController@getAllCities');
                Route::post('store', 'CityController@store');
                Route::post('update', 'CityController@update');
                Route::post('destroy', 'CityController@destroy');
             });  
             // admin editing and create new banks , delete ,update 
             Route::group(['prefix' => 'banks'], function () {
                Route::post('get-all-banks', 'BankController@getAllBanks');
                Route::post('store', 'BankController@store');
                Route::post('update', 'BankController@update');
                Route::post('destroy', 'BankController@destroy');
             }); 
          // admin editing and create new categories , delete ,update 
          Route::group(['prefix' => 'categories'], function () {
            Route::post('get-all-categories', 'CategoryController@getAllCategories');
            Route::post('store', 'CategoryController@store');
            Route::post('update', 'CategoryController@update');
            Route::post('destroy', 'CategoryController@destroy');
         });
             // admin editing and create new salon , delete ,update 
          Route::group(['prefix' => 'salons'], function () {
            Route::post('get-all-salons','SalonController@getAllSalons');
            Route::post('store', 'SalonController@store');
            Route::post('update', 'SalonController@update');
            Route::post('destroy', 'SalonController@destroy');
         }); 
          // admin editing and create new service , delete ,update 
          Route::group(['prefix' => 'services'], function () {
            Route::post('get-all-services','ServiceController@getAllServices');
            Route::post('store', 'ServiceController@store');
            Route::post('update', 'ServiceController@update');
            Route::post('destroy', 'ServiceController@destroy');
            }); 

              // admin editing and create new offers , delete ,update 
          Route::group(['prefix' => 'offers'], function () {
            Route::post('get-all-offers','OfferController@getAllOffers');
            Route::post('store', 'OfferController@store');
            Route::post('update', 'OfferController@update');
            Route::post('destroy', 'OfferController@destroy');
            }); 
              // admin editing and create new   Photo gallery , delete ,update 
          Route::group(['prefix' => 'photos'], function () {
            Route::post('get-all-photos','Photos_galleryController@getAllPhotos');
            Route::post('store', 'Photos_galleryController@store');
            Route::post('update', 'Photos_galleryController@update');
            Route::post('destroy', 'Photos_galleryController@destroy');
            }); 

             // admin editing and create new   order , delete ,update 
          Route::group(['prefix' => 'orders'], function () {
            Route::post('get-all-orders','OrderController@getAllOrders');
            Route::post('store', 'OrderController@store');
            Route::post('update', 'OrderController@update');
            Route::post('destroy', 'OrderController@destroy');
            }); 
              // admin editing and create new  user , delete ,update
            Route::group(['prefix' => 'users'], function () {
               Route::post('get-all-users','UserController@getAllUsers');
               Route::post('store', 'UserController@store');
               Route::post('update', 'UserController@update');
               Route::post('destroy', 'UserController@destroy');
               }); 
   
      });