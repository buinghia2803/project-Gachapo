<?php

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
});

Auth::routes();


/*
|--------------------------------------------------------------------------------
| Role user can access after login
|--------------------------------------------------------------------------------
*/
Route::group(['namespace' => 'EndUser', 'prefix' => '/', 'as' => 'user.', 'middleware' => ['user']], function () {
});

/*
|--------------------------------------------------------------------------------
| Role user can access without login
|--------------------------------------------------------------------------------
*/
Route::group(['namespace' => 'EndUser', 'prefix' => '/', 'as' => 'user.'], function () {
});

/*
|--------------------------------------------------------------------------------
| Role admin can access without login
|--------------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Auth\Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.submit');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/password/request', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset/{token}', 'ResetPasswordController@reset')->name('password.update');
});

/*
|--------------------------------------------------------------------------------
| Role admin can access after login
|--------------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/home', 'AdminController@index')->name('home');
    Route::get('/profile/{id}', 'AdminController@showProfile')->name('admin.profile');
    Route::put('/update/{id}', 'AdminController@updateProfile')->name('admin.update');

    /*
    |--------------------------------------------------------------------------------
    | User routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('user', 'UserController');
    Route::post('user/create-verify', 'UserController@verifyCreate')->name('user.create-verify');
    Route::post('user/verify-update', 'UserController@verifyUpdate')->name('user.verify-update');
    Route::post('user/export-file', 'UserController@exportFile')->name('user.export-file');
    Route::resource('category', 'CategoryController');

    /*
    |--------------------------------------------------------------------------------
    | Mail template route
    |--------------------------------------------------------------------------------
    */
    Route::get('mail-templates', 'MailTemplateController@index')->name('mail-templates.index');
    Route::post('mail-templates', 'MailTemplateController@store')->name('mail-templates.store');

    /*
    |--------------------------------------------------------------------------------
    | Banner Main Visual
    |--------------------------------------------------------------------------------
    */
    Route::post('banner-main-visuals/create-confirm', 'BannerMainVisualController@createConfirm')->name('banner-main-visuals.create-confirm');
    Route::post('banner-main-visuals/{id}/update-confirm', 'BannerMainVisualController@updateConfirm')->name('banner-main-visuals.update-confirm');
    Route::resource('banner-main-visuals', 'BannerMainVisualController');

    /*
    |--------------------------------------------------------------------------------
    | Banner Main
    |--------------------------------------------------------------------------------
    */
    Route::post('banners/update-show-type', 'BannerController@updateShowType')->name('banners.update-show-type');
    Route::post('banners/create-confirm', 'BannerController@createConfirm')->name('banners.create-confirm');
    Route::post('banners/{id}/update-confirm', 'BannerController@updateConfirm')->name('banners.update-confirm');
    Route::resource('banners', 'BannerController');

    /*
    |--------------------------------------------------------------------------------
    | Notification routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('notify', 'NotificationController');
    Route::post('notify/verify', 'NotificationController@verification')->name('notify.verify');
    Route::post('notify/update-verify', 'NotificationController@updateVerification')->name('notify.update-verify');

    /*
    |--------------------------------------------------------------------------------
    | Company routes
    |--------------------------------------------------------------------------------
    */
    Route::get('company-application', 'CompanyController@application')->name('company-application.index');
    Route::get('company-application/{id}/confirm-approve', 'CompanyController@confirmApprove')->name('company-application.confirm-approve');
    Route::post('company/{id}/approve', 'CompanyController@approve')->name('company.approve');
    Route::post('company/{id}/disapprove', 'CompanyController@disapprove')->name('company.disapprove');
    Route::resource('company', 'CompanyController');
    Route::post('company/verify', 'CompanyController@verifyCreate')->name('company.verify');
    Route::post('company/verify-update', 'CompanyController@verifyUpdate')->name('company.verify-update');
    Route::post('company/export-file', 'CompanyController@exportFile')->name('company.export-file');

    /*
    |--------------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('admin_users', 'AdminUserController');

    /*
    |--------------------------------------------------------------------------------
    | Pages routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('pages', 'PageController');

    /*
    |--------------------------------------------------------------------------------
    | Gacha Routes
    |--------------------------------------------------------------------------------
    */
    Route::post('gachas/delete-all', 'GachaController@destroyAll')->name('gachas.delete-all');
    Route::post('gachas/{id}/update-recommend', 'GachaController@updateRecommend')->name('gachas.update-recommend');
    Route::get('gachas/{id}/confirm', 'GachaController@confirm')->name('gachas.confirm');
    Route::post('gachas/{id}/approve', 'GachaController@approve')->name('gachas.approve');
    Route::post('gachas/{id}/disapprove', 'GachaController@disapprove')->name('gachas.disapprove');
    Route::resource('gachas', 'GachaController');

    /*
    |--------------------------------------------------------------------------------
    | Product Routes
    |--------------------------------------------------------------------------------
    */
    Route::get('products/{id}/confirm', 'ProductController@confirm')->name('products.confirm');

    /*
    |--------------------------------------------------------------------------------
    | Upload Routes
    |--------------------------------------------------------------------------------
    */
    Route::post('upload', 'UploadController@uploadImage')->name('upload-img');

    /*
    |--------------------------------------------------------------------------------
    | Delivery Routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('delivery', 'DeliveryController');
    Route::post('delivery/export-file', 'DeliveryController@exportFile')->name('delivery.export-file');
    Route::get('delivery/export-pdf/{id}', 'DeliveryController@exportPdf')->name('delivery.export-pdf');

    /*
    |--------------------------------------------------------------------------------
    | Analytics Routes
    |--------------------------------------------------------------------------------
    */
    Route::get('analytics/download', 'AnalyticController@download')->name('analytics.download');
    Route::get('analytics', 'AnalyticController@index')->name('analytics.index');
    Route::get('analytics/detail', 'AnalyticController@detail')->name('analytics.detail');
    Route::post('analytics/export-file', 'AnalyticController@exportFile')->name('analytics.export-file');

    /*
    |--------------------------------------------------------------------------------
    | Coupon Routes
    |--------------------------------------------------------------------------------
    */
    Route::get('coupon/generate-coupon-code', 'CouponController@generateCouponCode');
    Route::resource('coupon', 'CouponController');
});

/*
|--------------------------------------------------------------------------------
| Upload Routes
|--------------------------------------------------------------------------------
*/
Route::get('/home', 'HomeController@index')->name('home');

/*
|--------------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Auth\Company', 'prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.submit');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/password/forgot', 'ForgotPasswordController@formForgot')->name('password.forgot');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset/{token}', 'ResetPasswordController@reset')->name('password.update');
});

/*
|--------------------------------------------------------------------------------
| Route Company must be logged in to access
|--------------------------------------------------------------------------------
*/
Route::group(['namespace' => 'Company', 'prefix' => 'company', 'as' => 'company.', 'middleware' => ['company']], function () {
    Route::get('/verify-code', 'CompanyController@showVerifyCode')->name('show-verify-code');
    Route::post('/verify-code', 'CompanyController@verifyCode')->name('verify-code');
    Route::group(['middleware' => ['two-step-verification']], function () {
        Route::get('/', 'CompanyController@index')->name('index');
        Route::get('/profile', 'ProfileController@index')->name('profile');

        Route::get('/profile/show', 'ProfileController@showProfile')->name('profile.show');
        Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');

        Route::get('/profile/show/password', 'ProfileController@showPassword')->name('profile.show.password');
        Route::post('/profile/update/password', 'ProfileController@updatePassword')->name('profile.update.password');

        Route::get('/profile/show/setting-two-step-verification', 'ProfileController@showSettingTwoStepVerification')->name('profile.show.setting-two-step-verification');
        Route::post('/profile/update/setting-two-step-verification', 'ProfileController@updateSettingTwoStepVerification')->name('profile.post.setting-two-step-verification');

        Route::get('/profile/show/setting-notify', 'ProfileController@showSettingNotify')->name('profile.show.setting-notify');
        Route::post('/profile/update/setting-notify', 'ProfileController@updateSettingNotify')->name('profile.update.setting-notify');

        Route::get('/profile/show/credit-card', 'ProfileController@showCreditCard')->name('profile.show.credit-card');
        Route::post('/profile/update/credit-card', 'ProfileController@updateCreditCard')->name('profile.update.credit-card');

        Route::post('/profile/create/company', 'ProfileController@createCompany')->name('profile.create.company');
        Route::delete('/profile/delete','ProfileController@destroy')->name('profile.delete');

        Route::get('/review/show','ReviewController@index')->name('review.show');
        Route::get('/review/detail/{id}','ReviewController@show')->name('review.detail');

        Route::put('/review/update/{id}','ReviewController@update')->name('review.update');
        Route::get('/load-more','ReviewController@loadMore');

        /*
        |--------------------------------------------------------------------------------
        | Gacha Routes
        |--------------------------------------------------------------------------------
        */
        Route::post('gachas/delete-all', 'GachaController@destroyAll')->name('gachas.delete-all');
        Route::post('gachas/preview', 'GachaController@preview')->name('gachas.preview');
        Route::resource('gachas', 'GachaController');

        Route::post('products/delete-all', 'ProductController@destroyAll')->name('products.delete-all');
        Route::post('products/preview', 'ProductController@preview')->name('products.preview');
        Route::resource('products', 'ProductController');

    /*
    |--------------------------------------------------------------------------------
    | Delivery Routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('delivery', 'DeliveryController');
    Route::post('/export-file', 'DeliveryController@exportFile')->name('delivery.export-file');
    Route::get('delivery/export-pdf/{id}', 'DeliveryController@exportPdf')->name('delivery.export-pdf');
    /*
    |--------------------------------------------------------------------------------
    | Notify Routes
    |--------------------------------------------------------------------------------
    */
    Route::resource('notify', 'NotificationController');

        /*
        |--------------------------------------------------------------------------------
        | Dashboard Routes
        |--------------------------------------------------------------------------------
        */
        Route::get('dashboard', 'CompanyController@index')->name('dashboard');

        /*
        |--------------------------------------------------------------------------------
        | Analytics Routes
        |--------------------------------------------------------------------------------
        */
        Route::get('analytics', 'AnalyticController@index')->name('analytics.index');
        Route::get('analytics/export-file', 'AnalyticController@exportCsv')->name('analytics.download-csv');
    });
});

