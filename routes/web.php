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
	    Route::get('/permissions/list', 'PermissionsController@list')->name('permissions.list');
	    Route::get('/categories/list', 'CategoriesController@list')->name('categories.list');
	    Route::get('/courses/list', 'CoursesController@list')->name('courses.list');
	    Route::get('/courses/{id}/videos', 'CoursesController@videos')->name('courses.videos');
	    Route::get('/courses/{id}/slides', 'CoursesController@slides')->name('courses.slides');
	    Route::get('/courses/{id}/quizzes', 'CoursesController@quizzes')->name('courses.quizzes');
	    Route::get('/quizzes/{id}/questions', 'QuizzesController@questions')->name('quizzes.questions');
	    Route::get('/videos/list', 'CourseVideosController@list')->name('videos.list');
	    Route::post('/arrangevideos', 'CourseVideosController@arrange')->name('videos.arrange');
	    Route::get('/slides/list', 'CourseSlidesController@list')->name('slides.list');
	    Route::post('/arrangeslides', 'CourseSlidesController@arrange')->name('slides.arrange');
	    Route::get('/quizzes/list', 'QuizzesController@list')->name('quizzes.list');
	    Route::post('/arrangequizzes', 'QuizzesController@arrange')->name('quizzes.arrange');
	    Route::post('/arrangequestions', 'QuestionsController@arrange')->name('questions.arrange');
	    Route::get('/import/users', 'ImportsController@users')->name('import.users');
	    Route::post('/import/parseusers', 'ImportsController@parseusers')->name('import.parseusers');
	    Route::post('/import/saveusers', 'ImportsController@saveusers')->name('import.saveusers');

	    Route::resource('permissions', 'PermissionsController');
	    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

	    Route::resource('roles', 'RolesController');
	    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

	    Route::resource('users', 'UsersController');
	    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

	    Route::resource('categories', 'CategoriesController');
	    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');

	    Route::resource('courses', 'CoursesController');
	    Route::resource('videos', 'CourseVideosController');
	    Route::resource('slides', 'CourseSlidesController');
	    Route::resource('quizzes', 'QuizzesController');
	    Route::resource('questions', 'QuestionsController');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

//Auth::routes();

Route::post('/sendcode', 'Auth\LoginController@sendcode')->name('sendcode');
Route::get('/verifycode/{id}', 'Auth\LoginController@verifycode')->name('verifycode');
Route::post('/verifyusercode', 'Auth\LoginController@verifyusercode')->name('verifyusercode');
Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
});




