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
Route::get('/', ['as' => 'homepage', 'uses' => 'HomeController@show']);

/*
 * Routes related to authentication.
 */
Route::group(['as' => 'login::'], function () {
    Route::get('auth/login', ['as' => 'show', 'uses' => 'AuthController@getLogin']);
    Route::post('auth/login', ['as' => 'post', 'uses' => 'AuthController@postLogin']);
    Route::get('auth/logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    Route::get('password/reset/{token}', ['as' => 'resetpass::token', 'uses' => 'Auth\PasswordController@getReset']);
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
    Route::group(['prefix' => '{id}/member', 'as' => 'member::', 'middleware' => ['auth', 'permission:board']], function () {
        Route::get('nested', ['as' => 'nested::details', 'uses' => 'MemberAdminController@showDetails']);
        Route::get('impersonate', ['as' => 'impersonate', 'middleware' => ['auth', 'permission:admin'], 'uses' => 'MemberAdminController@impersonate']);

        Route::post('add', ['as' => 'add', 'uses' => 'MemberAdminController@addMembership']);
        Route::post('remove', ['as' => 'remove', 'uses' => 'MemberAdminController@endMembership']);
        Route::get('remove', ['as' => 'remove', 'uses' => 'MemberAdminController@endMembership']);
    });

    Route::group(['prefix' => 'admin', 'as' => 'member::', 'middleware' => ['auth', 'permission:board']], function () {
        Route::get('', ['as' => 'list', 'uses' => 'MemberAdminController@index']);
        Route::post('search/nested', ['as' => 'nested::search', 'uses' => 'MemberAdminController@showSearch']);
    });

    Route::get('quit_impersonating', ['as' => 'quitimpersonating', 'uses' => 'MemberAdminController@quitImpersonating']);

    Route::get('dashboard/{id?}', ['as' => 'dashboard', 'uses' => 'UserDashboardController@show']);
    Route::post('dashboard/{id?}', ['as' => 'dashboard', 'uses' => 'UserDashboardController@update']);

    Route::get('{id?}', ['as' => 'profile', 'middleware' => ['member'], 'uses' => 'UserProfileController@show']);

    /*
     * Routes related to addresses.
     */
    Route::group(['prefix' => '{id}/address', 'as' => 'address::'], function () {
        Route::get('add', ['as' => 'add', 'uses' => 'AddressController@addForm']);
        Route::post('add', ['as' => 'add', 'uses' => 'AddressController@add']);

        Route::post('delete/{address_id}', ['as' => 'delete', 'uses' => 'AddressController@delete']);

        Route::post('primary/{address_id}', ['as' => 'primary', 'uses' => 'AddressController@makePrimary']);

        Route::get('edit/{address_id}', ['as' => 'edit', 'uses' => 'AddressController@editForm']);
        Route::post('edit/{address_id}', ['as' => 'edit', 'uses' => 'AddressController@edit']);

        Route::get('togglehidden', ['as' => 'togglehidden', 'uses' => 'AddressController@toggleHidden']);
    });

    /*
     * Routes related to bank accounts
     */
    Route::group(['prefix' => '{id}/bank', 'as' => 'bank::'], function () {
        Route::get('add', ['as' => 'add', 'uses' => 'BankController@addForm']);
        Route::post('add', ['as' => 'add', 'uses' => 'BankController@add']);
        Route::post('delete', ['as' => 'delete', 'uses' => 'BankController@delete']);
    });

    /*
     * Routes related to bank accounts
     */
    Route::group(['prefix' => '{user_id}/study', 'as' => 'study::'], function () {
        Route::get('link', ['as' => 'add', 'uses' => 'StudyController@linkForm']);
        Route::post('link', ['as' => 'add', 'uses' => 'StudyController@link']);

        Route::get('unlink/{link_id}', ['as' => 'delete', 'uses' => 'StudyController@unlink']);

        Route::get('edit/{link_id}', ['as' => 'edit', 'uses' => 'StudyController@editLinkForm']);
        Route::post('edit/{link_id}', ['as' => 'edit', 'uses' => 'StudyController@editLink']);
    });

    /*
     * Routes related to 2FA
     */
    Route::group(['prefix' => '{user_id}/2fa', 'as' => '2fa::'], function () {
        Route::post('timebased', ['as' => 'addtimebased', 'uses' => 'TFAController@timebasedPost']);
        Route::get('deletetimebased', ['as' => 'deletetimebased', 'uses' => 'TFAController@timebasedDelete']);
        Route::post('yubikey', ['as' => 'addyubikey', 'uses' => 'TFAController@yubikeyPost']);
        Route::get('deleteyubikey', ['as' => 'deleteyubikey', 'uses' => 'TFAController@yubikeyDelete']);
    });
});
/**
 * Routes related to files.
 */
Route::group(['prefix' => 'file', 'as' => 'file::'], function () {
    Route::get('{id}/{hash}/{name}', ['as' => 'get', 'uses' => 'FileController@get']);
});
Route::group(['prefix' => 'image', 'as' => 'image::'], function () {
    Route::get('{id}/{hash}/{name}', ['as' => 'get', 'uses' => 'FileController@getImage']);
});

/*
 * Routes related to committees.
 */
Route::group(['prefix' => 'committee', 'as' => 'committee::'], function () {

    Route::group(['prefix' => 'membership', 'as' => 'membership::', 'middleware' => ['auth', 'permission:board']], function () {
        Route::post('add', ['as' => 'add', 'uses' => 'CommitteeController@addMembership']);
        Route::get('{id}/delete', ['as' => 'delete', 'uses' => 'CommitteeController@deleteMembership']);
        Route::get('{id}', ['as' => 'edit', 'uses' => 'CommitteeController@editMembershipForm']);
        Route::post('{id}', ['as' => 'edit', 'uses' => 'CommitteeController@editMembership']);
    });

    Route::get('list', ['as' => 'list', 'uses' => 'CommitteeController@overview']);

    Route::get('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@addForm']);
    Route::post('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@add']);

    Route::get('{id}', ['as' => 'show', 'uses' => 'CommitteeController@show']);

    Route::get('{id}/edit', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@editForm']);
    Route::post('{id}/edit', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@edit']);

    Route::post('{id}/image', ['as' => 'image', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@image']);

});

/*
 * Routes related to narrowcasting.
 */
Route::group(['prefix' => 'narrowcasting', 'as' => 'narrowcasting::'], function () {

    Route::get('/', ['as' => 'display', 'uses' => 'NarrowcastingController@display']);
    Route::get('/list', ['as' => 'list', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@index']);
    Route::get('/add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@create']);
    Route::post('/add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@store']);
    Route::get('/edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@edit']);
    Route::post('/edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@update']);
    Route::get('/delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@destroy']);
    Route::get('/clear', ['as' => 'clear', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@clear']);

});

/*
 * Routes related to events.
 * Important: routes in this block always use event_id or a relevent other ID. activity_id is in principle never used.
 */
Route::group(['prefix' => 'events', 'as' => 'event::'], function () {

    Route::get('/', ['as' => 'list', 'uses' => 'EventController@index']);
    Route::get('/add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'EventController@create']);
    Route::post('/add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'EventController@store']);
    Route::get('/edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'EventController@edit']);
    Route::post('/edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'EventController@update']);
    Route::get('/delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'EventController@destroy']);

    Route::get('/archive/{year}', ['as' => 'archive', 'uses' => 'EventController@archive']);

    // Related to participation
    Route::get('/participate/{id}', ['as' => 'addparticipation', 'uses' => 'ParticipationController@create']);
    Route::get('/unparticipate/{participation_id}', ['as' => 'deleteparticipation', 'uses' => 'ParticipationController@destroy']);

    // Related to activities
    Route::post('/signup/{id}', ['as'=>'addsignup', 'uses' => 'ActivityController@save']);
    Route::get('/signup/{id}/delete', ['as'=>'deletesignup', 'uses' => 'ActivityController@delete']);

    // Show event
    Route::get('/{id}', ['as' => 'show', 'uses' => 'EventController@show']);

});

/*
 * Routes related to studies.
 */
Route::group(['prefix' => 'study', 'middleware' => ['auth', 'permission:board'], 'as' => 'study::'], function () {

    Route::get('/', ['as' => 'list', 'uses' => 'StudyController@index']);
    Route::get('/add', ['as' => 'add', 'uses' => 'StudyController@create']);
    Route::post('/add', ['as' => 'add', 'uses' => 'StudyController@store']);
    Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'StudyController@edit']);
    Route::post('/edit/{id}', ['as' => 'edit', 'uses' => 'StudyController@update']);
    Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'StudyController@destroy']);

});

/**
 * Routes related to the Quote Corner.
 */
Route::group(['prefix' => 'quotes', 'as' => 'quotes::'], function () {
    Route::get('', ['as' => 'list', 'middleware' => ['auth'], 'uses' => 'QuoteCornerController@overview']);
    Route::post('add', ['as' => 'add', 'middleware' => ['auth'], 'uses' => 'QuoteCornerController@add']);
    Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'QuoteCornerController@delete']);
});

/*
 * Routes related to the API.
 */
Route::group(['prefix' => 'api', 'as' => 'api::'], function () {
    Route::get('events', ['as' => 'list', 'uses' => 'EventController@apiEvents']);
    Route::get('events/{id}', ['as' => 'get', 'uses' => 'EventController@apiEventsSingle']);
    Route::get('events/{id}/members', ['as' => 'getMembers', 'uses' => 'EventController@apiEventsMembers']);

    Route::get('members', ['as' => 'members', 'uses' => 'ApiController@members']);
    Route::get('narrowcasting', ['as' => 'narrowcasting', 'uses' => 'NarrowcastingController@indexApi']);
});
