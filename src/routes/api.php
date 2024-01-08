<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    /*
    |--------------------------------------------------------------------------------
    | Router login
    |--------------------------------------------------------------------------------
    */
    Route::post('login', 'UserController@login');
    Route::post('user', 'UserController@store');

    /*
    |--------------------------------------------------------------------------------
    | API Company
    |--------------------------------------------------------------------------------
    */
    Route::post('company', 'CompanyController@store');

    /*
    |--------------------------------------------------------------------------------
    | API Contact
    |--------------------------------------------------------------------------------
    */
    Route::post('contact', 'ContactController@store');

    /*
    |--------------------------------------------------------------------------------
    | API Password reset.
    |--------------------------------------------------------------------------------
    */
    Route::get('generate-link', 'UserController@getGenerateLinkResetPW');
    Route::post('check-secret-key', 'UserController@checkSecretKey');
    Route::post('password-reset', 'UserController@passwordReset');

    /*
    |--------------------------------------------------------------------------------
    | API Home page
    |--------------------------------------------------------------------------------
    */
    Route::get('home', 'HomeController@index');

    /*
    |--------------------------------------------------------------------------------
    | API Categories
    |--------------------------------------------------------------------------------
    */
    Route::apiResource('category', 'CategoryController');
    Route::get('gacha/{id}/reviews/', 'GachaController@getListGachaReview');

    /*
    |--------------------------------------------------------------------------------
    | API Verification For User.
    |--------------------------------------------------------------------------------
    */
    Route::get('user/verification', 'UserController@verificationCode');

    /*
    |--------------------------------------------------------------------------------
    | API Static Page.
    |--------------------------------------------------------------------------------
    */
    Route::get('page', 'PageController@index');
    Route::get('page/{type}', 'PageController@getPageWithType');

    /*
    |--------------------------------------------------------------------------------
    | API Gacha.
    |--------------------------------------------------------------------------------
    */
    Route::get('gacha', 'GachaController@index');
    Route::get('gacha-by-id/{id}', 'GachaController@getGachaById');
});

Route::group(['namespace' => 'Api', 'middleware' => ['auth:api']], function () {
    // Route::group(['namespace' => 'Api', 'middleware' => []], function () {
    /*
    |--------------------------------------------------------------------------------
    | API User
    |--------------------------------------------------------------------------------
    */
    Route::get('user', 'UserController@index');
    Route::put('user/{user}', 'UserController@update');
    Route::delete('user/{user}', 'UserController@update');

    Route::post('logout', 'UserController@logout');
    Route::group(['prefix' => 'auth'], function () {
        Route::get('me', 'UserController@getProfile');
    });
    Route::get('user/{user}/get-info-shipping', 'UserController@getInfoShipping');
    Route::put('user/{user}/update-info-shipping', 'UserController@updateInfoShipping');
    Route::post('user/other-payment-method', 'UserController@createOtherPaymentMethod');
    Route::get('user/{user}/basic-user-info', 'UserController@getInfoBaseOfUserByUserId');
    Route::get('user/{user}/user-info-by-type/{type}', 'UserController@getInfoUserByUserIdAndType');
    Route::put('user/{user}/type/{type}', 'UserController@updateUserInfoByType');
    Route::put('user/{user}/leave', 'UserController@withdrawal');
    Route::get('user/browsing-history-gacha', 'UserController@getBrowsingHistoryGacha');

    /*
    |--------------------------------------------------------------------------------
    | API User Credit Card.
    |--------------------------------------------------------------------------------
    */
    Route::apiResource('card', 'UserCreditCardController');

    /*
    |--------------------------------------------------------------------------------
    | API Gacha.
    |--------------------------------------------------------------------------------
    */

    // Route::post('gacha', 'GachaController@store');
    // Route::delete('gacha/{gacha}', 'GachaController@destroy');

    // Route::apiResource('gacha', 'GachaController');
    Route::post('gacha/buy/{gacha}', 'GachaController@buyGacha');
    Route::post('favorite/like', 'GachaController@eventLikeGacha');
    Route::post('favorite/unlike', 'GachaController@eventUnLikeGacha');
    Route::get('gacha/favorite/list', 'GachaController@getListGachaFavoritesByUserId');

    /*
    |--------------------------------------------------------------------------------
    | API Static Page.
    |--------------------------------------------------------------------------------
    */
    Route::get('user/notification', 'NotificationController@index');
    Route::get('user/notification/{notification}', 'NotificationController@getNotificeById');

    /*
    |--------------------------------------------------------------------------------
    | API Order
    |--------------------------------------------------------------------------------
    */
    Route::get('order', 'OrderController@index');
    Route::get('order/{order}', 'OrderController@show');
    Route::post('order/review', 'OrderController@createReviewOrder');
    Route::get('review-by-user-id', 'OrderController@getOrderByUserId');
});
