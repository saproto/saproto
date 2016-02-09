<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
 * The main route for the frontpage.
 */
Route::get('/', ['as' => 'homepage', function () {
    return view('website/default/default');
}]);

/*
 * Routes related to authentication.
 */
Route::group(['as' => 'login::'], function () {
    Route::get('auth/login', ['as' => 'show', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('auth/login', ['middleware' => 'utwente.auth', 'as' => 'post', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

    Route::get('password/reset/{token}', ['uses' => 'Auth\PasswordController@getReset']);
    Route::post('password/reset', ['as' => 'resetpass::submit', 'uses' => 'Auth\PasswordController@postReset']);
    Route::get('password/email', ['as' => 'resetpass', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('password/email', ['as' => 'resetpass::send', 'uses' => 'Auth\PasswordController@postEmail']);
});

/*Route::group(['prefix' => 'test', 'as' => 'test::', 'middleware' => ['auth']], function() {
    Route::get('edit', ['uses' => 'FormTestController@index', 'middleware' => ['role:admin']]);
    Route::get('edit/{id}', ['uses' => 'FormTestController@edit']);
    Route::put('edit/{id}', ['as' => 'edit::update', 'uses' => 'FormTestController@update']);
    Route::post('test/edit', ['as' => 'edit::store   ', 'uses' => 'FormTestController@store']);
});*/

/*
 * Routes related to user profiles.
 */
Route::group(['prefix' => 'profile', 'as' => 'profile::'], function() {
    Route::get('edit', ['uses' => 'UserPreferenceController@editOwn', 'as' => 'editOwn', 'middleware' => ['auth']]);
    Route::get('', ['uses' => 'UserPreferenceController@showOwn', 'middleware' => ['auth']]);
    Route::get('{id}', ['uses' => 'UserPreferenceController@show', 'middleware' => ['auth']]);
    Route::get('edit/{id}', ['uses' => 'UserPreferenceController@edit', 'middleware' => ['auth', 'role:admin']]);
    Route::put('edit/{id}', ['uses' => 'UserPreferenceController@update', 'middleware' => ['auth', 'role:admin']]);
});
