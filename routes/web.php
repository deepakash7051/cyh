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


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::get('/login', 'AuthController@getLogin');
    Route::post('/login', 'AuthController@Login')->name('login');
    Route::middleware(['auth'])->group(function () {
    	Route::get('/', 'HomeController@index')->name('home');
    	Route::get('/users/list', 'UsersController@list')->name('users.list');
	    Route::get('/permissions/list', 'PermissionsController@list')->name('permissions.list');
	    Route::get('/categories/list', 'CategoriesController@list')->name('categories.list');
	    Route::get('/courses/list', 'CoursesController@list')->name('courses.list');

	    Route::resource('permissions', 'PermissionsController');
	    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

	    Route::resource('roles', 'RolesController');
	    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

	    Route::resource('users', 'UsersController');
	    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

	    Route::resource('categories', 'CategoriesController');
	    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');

	    Route::resource('courses', 'CoursesController');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

//Auth::routes();

Route::post('/sendcode', 'HomeController@sendcode')->name('sendcode');
Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
});




