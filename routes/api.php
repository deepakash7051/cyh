<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1',
    'namespace' => 'Api\v1'

], function ($router) {
    Route::post('register', 'RegisterController@register');
	Route::post('login', 'LoginController@login');
    Route::post('forgotpassword', 'LoginController@forgotpassword');

    //Route::post('login/{provider}/callback','SocialController@Callback');
});

Route::group(['middleware' => 'auth.jwt', 'prefix' => 'v1', 'namespace' => 'Api\v1' ], function ($router) {

   // Route::get('email/resend', 'VerificationController@resend');

    Route::post('logout', 'LoginController@logout');
    Route::get('refresh', 'RegisterController@refresh');
   // Route::post('editdetails', 'UsersController@editdetails');
    //Route::post('saveimages', 'UsersController@saveimages');
    Route::apiResource('/user', 'UserController');
    Route::post('/user-update', 'UserController@update');
});