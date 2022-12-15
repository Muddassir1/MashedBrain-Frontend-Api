<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::post('login', 'LoginController@login');
Route::post('register', 'RegisterController@register');
Route::post('phone-verify', 'RegisterController@verify');

Route::post('payment/ipn', 'PaymentController@ipn');
Route::post('payment/success', 'PaymentController@success');
Route::post('payment/fail', 'PaymentController@fail');
Route::post('payment/cancel', 'PaymentController@cancel');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('books/search', 'BookController@search');
    Route::get('books/latest', 'BookController@latest');
    Route::resource('books', 'BookController', ["as" => "api"]);

    Route::get('user/settings', 'UserController@settings');
    Route::patch('user/settings', 'UserController@updateSettings');
    Route::post('user/categories', 'UserController@updateCategories');
    Route::post('user/membership', 'UserController@updateMembership');

    Route::resource('categories', 'CategoryController', ["as" => "api"]);
    Route::resource('memberships', 'MembershipController', ["as" => "api"])->only(['index']);

    Route::post('payment/verify', 'PaymentController@verify');
});
