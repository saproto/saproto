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

Route::group(['middleware' => 'dev'], function () {

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

    /*
     * Routes related to user profiles.
     */
    Route::group(['prefix' => 'user', 'as' => 'user::', 'middleware' => ['auth']], function () {
        Route::get('{id?}', ['as' => 'profile', 'uses' => 'UserProfileController@show']);

        /*
         * Routes related to addresses.
         */
        Route::group(['prefix' => '{id}/address', 'as' => 'address::', 'middleware' => ['auth']], function () {
            Route::get('add', ['as' => 'add', 'uses' => 'AddressController@addForm']);
            Route::post('add', ['as' => 'add', 'uses' => 'AddressController@add']);
            Route::delete('delete/{address_id}', ['as' => 'delete', 'uses' => 'AddressController@delete']);
        });

        /*
         * Routes related to members.
         */
        Route::group(['prefix' => 'member', 'as' => 'member::', 'middleware' => ['auth', 'role:board']], function () {
            Route::get('', ['as' => 'list', 'uses' => 'MemberAdminController@index']);
            Route::post('search/nested', ['as' => 'nested::search', 'uses' => 'MemberAdminController@showSearch']);
            Route::get('{id}/nested', ['as' => 'nested::details', 'uses' => 'MemberAdminController@showDetails']);
            Route::get('{id}/impersonate', ['as' => 'impersonate', 'uses' => 'MemberAdminController@impersonate']);
        });
    });

});