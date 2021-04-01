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

	Route::get('/', 'AuthController@getLogin');
    Route::get('/login', 'AuthController@getLogin');
    Route::post('/login', 'AuthController@Login')->name('login');
    
    Route::middleware(['auth'])->group(function () {
    	Route::get('/home', 'HomeController@index')->name('home');
    	Route::get('/users/courses', 'UsersController@getCourses');
    	Route::get('/users/list', 'UsersController@list')->name('users.list');
	    Route::get('/import/users', 'ImportsController@users')->name('import.users');
	    Route::post('/import/parseusers', 'ImportsController@parseusers')->name('import.parseusers');
	    Route::post('/import/saveusers', 'ImportsController@saveusers')->name('import.saveusers');

	    Route::resource('permissions', 'PermissionsController');
	    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

	    Route::resource('roles', 'RolesController');
	    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

	    Route::resource('users', 'UsersController');
	    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
		
		Route::resource('designs','DesignController');
		Route::get('designlist','DesignController@list')->name('designlist');
		Route::get('deleteDesign/{id}','DesignController@deleteDesign')->name('deleteDesign');
		Route::resource('proposals','ProposalController');
		Route::get('proposallist','ProposalController@list')->name('proposallist');
		Route::resource('products','ProductController');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);


