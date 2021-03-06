<?php

declare(strict_types=1);
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

/** Routes associated with login. */
Route::get('/', 'LoginController@index')->name('login');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@validateUser')->name('post.login');

/** Route for home page. Takes us to the SPA. */
Route::get('/home', 'SPAController@index')->name('home')->middleware('auth');
Route::get('/data/{term?}', 'SPAController@getData')->middleware('auth');
Route::get('/term/{term?}', 'SPAController@getCurrentTerm')->middleware('auth');

/** Route for logout. */
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});



/** Web Service API Routes. */
Route::get('/courses/{term}', 'WebResourceController@courses')->middleware('auth');
Route::get('/roster/{term}/{course}', 'SPAController@getRoster')->middleware('auth');
Route::get('/student/{email}', 'WebResourceController@student')->middleware('auth');

/** Roster API Routes. */
Route::get('/students/{term}/{course}', 'RosterController@getStudents')->middleware('auth');

/** Student API Routes */
Route::get('/faculty-profile/{email}', 'FacultyProfileController@getFacultyProfile')->middleware('auth');
Route::get('/student-profile/{email}', 'StudentProfileController@getProfile')->middleware('auth');
Route::post('/student-profile-alternative','StudentProfileController@getProfileWithNoEmail')->middleware('auth');
Route::post('/update-note', 'StudentProfileController@updateNotes')->middleware('auth');

/** User Settings API Routes */
Route::get('/get-settings', 'UserSettingsController@getSettings')->middleware('auth');
Route::post('/update-theme', 'UserSettingsController@updateTheme')->middleware('auth');

/** Upload Permission API Routes */
Route::get('/get-upload-permission', 'UploadPermissionController@getUploadPermission')->middleware('auth');
Route::post('/store-permission', 'UploadPermissionController@storePermission')->middleware('auth');

/** Support and Feedback */
Route::get('feedback', '\CSUNMetaLab\Support\Http\Controllers\FeedbackController@create')->name('feedback.create')->middleware('auth');
Route::post('feedback', '\CSUNMetaLab\Support\Http\Controllers\FeedbackController@store')->name('feedback.store')->middleware('auth');
Route::get('support', '\CSUNMetaLab\Support\Http\Controllers\SupportController@create')->name('support.create')->middleware('auth');
Route::post('support', '\CSUNMetaLab\Support\Http\Controllers\SupportController@store')->name('support.store')->middleware('auth');

/**
 * Image CRUD Routes.
 */
Route::group(['prefix' => 'api'], function () {
    Route::post('/upload', 'ImageController@uploadImage')->middleware('auth');
    Route::post('/priority', 'ImageController@updatePriority')->middleware('auth');
});

/** META+LAB Feedback Routes */
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('support', '\CSUNMetaLab\Support\Http\Controllers\SupportController@create')->name('support.create');
//     Route::post('support', '\CSUNMetaLab\Support\Http\Controllers\SupportController@store')->name('support.store');

//     Route::get('feedback', '\CSUNMetaLab\Support\Http\Controllers\FeedbackController@create')->name('feedback.create');
//     Route::post('feedback', '\CSUNMetaLab\Support\Http\Controllers\FeedbackController@store')->name('feedback.store');
//   });

