<?php

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator', 'can' => 'create.company, view.company, update.company, delete.company'],
    function () {
        Route::get('/company/create-pass', 'CompanyController@createPassSlotTemplate');
        Route::post('/company/save-pass-template', 'CompanyController@savePassSlotTemplate');
        Route::resource('company', 'CompanyController');
    }
);

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator|manager', 'can' => 'create.branch, view.branch, update.branch, delete.branch'],
    function () {
        Route::get('/branch/add-manager', 'BranchController@addManager');
        Route::get('/branch/add-staff', 'BranchController@addStaff');
        Route::post('/branch/create-user', 'BranchController@saveUser');
        Route::get('/branch/show-users/{companyId?}', 'BranchController@showUsers');
        Route::resource('branch', 'BranchController');
    }
);

Route::group(['prefix'=> 'member', 'middleware' => ['acl'], 'is' => 'administrator'], function () {
    Route::get('search', 'MemberController@search');
    Route::get('import', 'MemberController@import');
    Route::get('export', 'MemberController@export');
    Route::get('export-member/{companyId?}', 'MemberController@exportMember');
});

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator|manager|staff', 'can' => 'create.member, view.member, update.member, delete.member'],
    function () {
        Route::get('/member/add-points/{memberId}', 'MemberPointsController@addPoints');
        Route::post('/member/save-points', 'MemberPointsController@savePoints');
        Route::get('/member/points-log', 'MemberPointsController@pointsLog');
        Route::resource('member', 'MemberController');
    }
);

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator|manager|staff', 'can' => 'create.transaction, view.transaction, update.transaction, delete.transaction'],
    function () {
        Route::get('transaction/create/{memberId}', 'TransactionController@create');
        Route::get('transaction/searchProduct', 'TransactionController@searchProduct');
        Route::resource('transaction', 'TransactionController', ['except' => ['create']]);
    }
);

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator|manager|staff', 'can' => 'create.product.category, view.product.category, update.product.category, delete.product.category'],
    function () {
        Route::resource('product/category', 'ProductCategoryController');
    }
);

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator|manager', 'can' => 'create.member, view.member, update.member, delete.member'],
    function () {
        Route::resource('loyalty', 'LoyaltyConfigController');
    }
);

Route::group(
    ['middleware' => ['admin', 'acl'], 'is' => 'administrator|manager', 'can' => 'create.member, view.member, update.member, delete.member'],
    function () {
        Route::resource('rewards', 'RewardsController');
        Route::get('rewards/items/{memberId}', 'RewardsController@items');
        Route::post('rewards/redeem', 'RewardsController@redeem');
    }
);

Route::group(['middlewareGroups' => ['web']],
    function () {
        //login routes...
        Route::get('/admin/login','AdminAuth\AuthController@showLoginForm');
        Route::post('/admin/login','AdminAuth\AuthController@login');
        Route::get('/admin/logout','AdminAuth\AuthController@logout');

        //registration routes...
        Route::get('/register', 'AdminAuth\AuthController@showRegistrationForm');
        Route::post('/register', 'AdminAuth\AuthController@register');

        //reset password
        Route::post('/password/email','AdminAuth\PasswordController@sendResetLinkEmail');
        Route::post('/password/reset','AdminAuth\PasswordController@reset');
        Route::get('/password/reset/{token?}','AdminAuth\PasswordController@showResetForm');

        Route::get('/admin', 'AdminController@index');

    //    DELETE THIS
        Route::get('/admin/create-permission', 'AdminController@createPermission');
        Route::get('/admin/create-role', 'AdminController@createRole');
        Route::get('/admin/assign-role', 'AdminController@assignPermToRole');
        Route::get('/admin/assign-user-role', 'AdminController@assignUserRole');
    }
);

Route::get('/', 'HomeController@index');
//Route::get('/send-mail', 'HomeController@sendMail');  //just for testing
