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

Route::get('/', 'HomeController@index');
// Auth::routes();
Auth::routes(['verify' => true, 'register' => false, 'reset' => false]);
Route::get('/home', 'HomeController@index')->name('home');



Route::middleware(['auth'])->group(function(){

    //Service
      Route::get('/service', function(){
        return view('service.indexService');
    });

    //Cashier

    Route::get('/service/cashier', 'Service\CashierController@index');
    Route::get('/service/getMenuByCategory/{category_id}', 'Service\CashierController@getMenuByCategory');

    Route::get('/service/getTables', 'Service\CashierController@getTables');

    Route::get('/service/getSale/{table_id}', 'Service\CashierController@getSale');


    Route::post('/service/orderFood', 'Service\CashierController@orderFood');
    Route::post('/service/deleteOrderFood', 'Service\CashierController@deleteOrderFood');
    Route::post('/service/confirmOrderFood', 'Service\CashierController@confirmOrderFood');

    Route::post('/service/savePayment', 'Service\CashierController@savePayment');

    Route::get('/service/cashier/showReceipt/{saleID}', 'Service\CashierController@showReceipt');


});

// Managment 
Route::middleware(['auth', 'VerifyAdmin'])->group(function(){

    Route::get('/management', function(){
        return view('management.index');
    });

    Route::resource('/management/category', 'Management\CategoryController');
    Route::resource('/management/menu', 'Management\MenuController');
    Route::resource('/management/table', 'Management\TableController');
    Route::resource('/management/user', 'Management\UserController');

    // Report

    Route::get('/report', 'Report\ReportController@index');
    Route::get('/report/show', 'Report\ReportController@show');

    //Export

    Route::get('/report/show/export', 'Report\ReportController@export');

});