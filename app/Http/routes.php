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
        /*
         * Routes related to members.
         */
        Route::group(['prefix' => '{id}/member', 'as' => 'member::', 'middleware' => ['auth', 'role:board|root']], function () {
            Route::get('nested', ['as' => 'nested::details', 'uses' => 'MemberAdminController@showDetails']);
            Route::get('impersonate', ['as' => 'impersonate', 'uses' => 'MemberAdminController@impersonate']);
        });

        Route::group(['prefix' => 'members', 'as' => 'member::'], function () {
            Route::get('', ['as' => 'list', 'uses' => 'MemberAdminController@index']);
            Route::post('search/nested', ['as' => 'nested::search', 'uses' => 'MemberAdminController@showSearch']);
        });

        Route::get('quit_impersonating', ['as' => 'quitimpersonating', 'uses' => 'MemberAdminController@quitImpersonating']);

        Route::get('{id?}', ['as' => 'profile', 'uses' => 'UserProfileController@show']);

        /*
         * Routes related to addresses.
         */
        Route::group(['prefix' => '{id}/address', 'as' => 'address::', 'middleware' => ['auth']], function () {
            Route::get('add', ['as' => 'add', 'uses' => 'AddressController@addForm']);
            Route::post('add', ['as' => 'add', 'uses' => 'AddressController@add']);
            Route::post('delete/{address_id}', ['as' => 'delete', 'uses' => 'AddressController@delete']);
            Route::post('primary/{address_id}', ['as' => 'primary', 'uses' => 'AddressController@makePrimary']);
        });

        /*
         * Routes related to bank accounts
         */
        Route::group(['prefix' => '{id}/bank', 'as' => 'bank::', 'middleware' => ['auth']], function () {
            Route::get('add', ['as' => 'add', 'uses' => 'BankController@addForm']);
            Route::post('add', ['as' => 'add', 'uses' => 'BankController@add']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'BankController@delete']);
        });

        /*
         * Routes related to bank accounts
         */
        Route::group(['prefix' => '{id}/study', 'as' => 'study::', 'middleware' => ['auth']], function () {
            Route::get('link', ['as' => 'add', 'uses' => 'StudyController@linkForm']);
            Route::post('link', ['as' => 'add', 'uses' => 'StudyController@link']);

            Route::post('unlink/{study_id}', ['as' => 'delete', 'uses' => 'StudyController@unlink']);

            Route::get('edit/{study_id}', ['as' => 'edit', 'uses' => 'StudyController@editLinkForm']);
            Route::post('edit/{study_id}', ['as' => 'edit', 'uses' => 'StudyController@editLink']);
        });
    });

});