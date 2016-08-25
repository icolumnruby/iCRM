<?php

//Route::auth();

Route::get('/contact/search', 'ContactController@search');
Route::get('/contact/import', 'ContactController@import');
Route::get('/contact/export', 'ContactController@export');
Route::resource('contact', 'ContactController');

Route::resource('meta', 'MetaController');
Route::get('/meta/addOption/{metaId}', 'MetaController@addOption');
Route::post('/meta/saveOption', 'MetaController@saveOption');

Route::get('transaction/create/{contactId}', 'TransactionController@create');
Route::get('transaction/searchProduct', 'TransactionController@searchProduct');
Route::resource('transaction', 'TransactionController', ['except' => ['create']]);

Route::resource('product', 'ProductController');
Route::resource('brand', 'BrandController');
Route::resource('branch', 'BranchController');


Route::group(['middleware' => ['web']], function () {
    //Login Routes...
    Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
    Route::post('/admin/login','AdminAuth\AuthController@login');
    Route::get('/admin/logout','AdminAuth\AuthController@logout');

    // Registration Routes...
    Route::get('admin/register', 'AdminAuth\AuthController@showRegistrationForm');
    Route::post('admin/register', 'AdminAuth\AuthController@register');

    //reset password
    Route::post('admin/password/email','AdminAuth\PasswordController@sendResetLinkEmail');
    Route::post('admin/password/reset','AdminAuth\PasswordController@reset');
    Route::get('admin/password/reset/{token?}','AdminAuth\PasswordController@showResetForm');

    Route::get('/admin', 'AdminController@index');

});


//Route::auth();

Route::get('/home', 'HomeController@index');
