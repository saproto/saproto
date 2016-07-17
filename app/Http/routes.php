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

    Route::get('auth/register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
    Route::post('auth/register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
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
    Route::group(['prefix' => 'rfidcard/{id}', 'as' => 'rfid::'], function () {
        Route::get('delete', ['as' => 'delete', 'uses' => 'RfidCardController@destroy']);
        Route::get('edit', ['as' => 'edit', 'uses' => 'RfidCardController@edit']);
        Route::post('edit', ['as' => 'edit', 'uses' => 'RfidCardController@update']);
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
Route::post('membercard/print', ['as' => 'membercard::print', 'middleware' => ['auth', 'permission:board'], 'uses' => 'MemberCardController@startprint']);
Route::get('membercard/{id}', ['as' => 'membercard::download', 'uses' => 'MemberCardController@download']);

Route::post('memberform/print', ['as' => 'memberform::print', 'middleware' => ['auth', 'permission:board'], 'uses' => 'MemberAdminController@printForm']);
Route::get('memberform/{id}', ['as' => 'memberform::download', 'uses' => 'MemberAdminController@showForm']);

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
    Route::get('list', ['as' => 'list', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@index']);
    Route::get('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@create']);
    Route::post('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@edit']);
    Route::post('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@destroy']);
    Route::get('clear', ['as' => 'clear', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@clear']);

});

/*
 * Routes related to events.
 * Important: routes in this block always use event_id or a relevent other ID. activity_id is in principle never used.
 */
Route::group(['prefix' => 'events', 'as' => 'event::'], function () {

    Route::group(['prefix' => 'financial', 'as' => 'financial::', 'middleware' => ['permission:finadmin']], function () {
        Route::get('', ['as' => 'list', 'uses' => 'EventController@finindex']);
        Route::post('close/{id}', ['as' => 'close', 'uses' => 'EventController@finclose']);
    });

    Route::get('', ['as' => 'list', 'uses' => 'EventController@index']);
    Route::get('add', ['as' => 'add', 'middleware' => ['permission:board'], 'uses' => 'EventController@create']);
    Route::post('add', ['as' => 'add', 'middleware' => ['permission:board'], 'uses' => 'EventController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'middleware' => ['permission:board'], 'uses' => 'EventController@edit']);
    Route::post('edit/{id}', ['as' => 'edit', 'middleware' => ['permission:board'], 'uses' => 'EventController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['permission:board'], 'uses' => 'EventController@destroy']);

    Route::get('archive/{year}', ['as' => 'archive', 'uses' => 'EventController@archive']);

    // Related to participation
    Route::get('participate/{id}', ['as' => 'addparticipation', 'middleware' => ['member'], 'uses' => 'ParticipationController@create']);
    Route::get('unparticipate/{participation_id}', ['as' => 'deleteparticipation', 'uses' => 'ParticipationController@destroy']);

    // Related to activities
    Route::post('signup/{id}', ['as' => 'addsignup', 'middleware' => ['permission:board'], 'uses' => 'ActivityController@save']);
    Route::get('signup/{id}/delete', ['as' => 'deletesignup', 'middleware' => ['permission:board'], 'uses' => 'ActivityController@delete']);

    // Show event
    Route::get('{id}', ['as' => 'show', 'uses' => 'EventController@show']);

});

/*
 * Routes related to pages.
 */
Route::group(['prefix' => 'page', 'as' => 'page::'], function () {

    Route::group(['middleware' => ['auth', 'permission:board']], function () {
        Route::get('', ['as' => 'list', 'uses' => 'PageController@index']);
        Route::get('add', ['as' => 'add', 'uses' => 'PageController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'PageController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PageController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'PageController@update']);
        Route::post('edit/{id}/image', ['as' => 'image', 'uses' => 'PageController@featuredImage']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'PageController@destroy']);

        Route::group(['prefix' => '/edit/{id}/file', 'as' => 'file::'], function () {
            Route::post('add', ['as' => 'add', 'uses' => 'PageController@addFile']);
            Route::get('{file_id}/delete', ['as' => 'delete', 'uses' => 'PageController@deleteFile']);
        });

    });

    Route::get('{slug}', ['as' => 'show', 'uses' => 'PageController@show']);

});

/*
 * Routes related to menu.
 */
Route::group(['prefix' => 'menu', 'as' => 'menu::', 'middleware' => ['auth', 'permission:board']], function () {
    Route::get('', ['as' => 'list', 'uses' => 'MenuController@index']);
    Route::get('add', ['as' => 'add', 'uses' => 'MenuController@create']);
    Route::post('add', ['as' => 'add', 'uses' => 'MenuController@store']);

    Route::get('up/{id}', ['as' => 'orderUp', 'uses' => 'MenuController@orderUp']);
    Route::get('down/{id}', ['as' => 'orderDown', 'uses' => 'MenuController@orderDown']);

    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'MenuController@edit']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'MenuController@destroy']);
});


/*
 * Routes related to studies.
 */
Route::group(['prefix' => 'study', 'middleware' => ['auth', 'permission:board'], 'as' => 'study::'], function () {

    Route::get('', ['as' => 'list', 'uses' => 'StudyController@index']);
    Route::get('add', ['as' => 'add', 'uses' => 'StudyController@create']);
    Route::post('add', ['as' => 'add', 'uses' => 'StudyController@store']);
    Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'StudyController@edit']);
    Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'StudyController@update']);
    Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'StudyController@destroy']);

});

/**
 * Routes related to the Quote Corner.
 */
Route::group(['prefix' => 'quotes', 'middleware' => ['member'], 'as' => 'quotes::'], function () {
    Route::get('', ['as' => 'list', 'middleware' => ['auth'], 'uses' => 'QuoteCornerController@overview']);
    Route::post('add', ['as' => 'add', 'middleware' => ['auth'], 'uses' => 'QuoteCornerController@add']);
    Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'QuoteCornerController@delete']);
});

/**
 * Routes related to the OmNomCom.
 */
Route::group(['prefix' => 'omnomcom', 'as' => 'omnomcom::'], function () {

    Route::group(['prefix' => 'store', 'as' => 'store::'], function () {
        Route::get('{store?}', ['as' => 'show', 'uses' => 'OmNomController@display']);
        Route::post('rfid/add', ['as' => 'rfidadd', 'uses' => 'RfidCardController@store']);
        Route::post('{store}/buy', ['as' => 'buy', 'uses' => 'OmNomController@buy']);
    });

    Route::group(['prefix' => 'orders', 'middleware' => ['auth'], 'as' => 'orders::'], function () {
        Route::get('', ['as' => 'adminlist', 'middleware' => ['permission:omnomcom'], 'uses' => 'OrderLineController@adminindex']);
        Route::get('history/{user_id?}/{date?}', ['as' => 'list', 'uses' => 'OrderLineController@index']);

        Route::post('add/bulk', ['as' => 'addbulk', 'middleware' => ['permission:omnomcom'], 'uses' => 'OrderLineController@bulkStore']);
        Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['permission:omnomcom'], 'uses' => 'OrderLineController@destroy']);
    });

    Route::group(['prefix' => 'accounts', 'middleware' => ['permission:finadmin'], 'as' => 'accounts::'], function () {
        Route::get('', ['as' => 'list', 'uses' => 'AccountController@index']);
        Route::get('add', ['as' => 'add', 'uses' => 'AccountController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'AccountController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'AccountController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'AccountController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'AccountController@destroy']);
        Route::get('{id}', ['as' => 'show', 'uses' => 'AccountController@show']);
    });

    Route::group(['prefix' => 'products', 'middleware' => ['permission:omnomcom'], 'as' => 'products::'], function () {
        Route::get('', ['as' => 'list', 'uses' => 'ProductController@index']);
        Route::get('add', ['as' => 'add', 'uses' => 'ProductController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'ProductController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProductController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'ProductController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ProductController@destroy']);
        Route::get('{id}', ['as' => 'show', 'uses' => 'ProductController@show']);

        Route::post('update/bulk', ['as' => 'bulkupdate', 'middleware' => ['permission:omnomcom'], 'uses' => 'ProductController@bulkUpdate']);
    });

    Route::group(['prefix' => 'categories', 'middleware' => ['permission:omnomcom'], 'as' => 'categories::'], function () {
        Route::get('', ['as' => 'list', 'uses' => 'ProductCategoryController@index']);
        Route::get('add', ['as' => 'add', 'uses' => 'ProductCategoryController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'ProductCategoryController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProductCategoryController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'ProductCategoryController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ProductCategoryController@destroy']);
        Route::get('{id}', ['as' => 'show', 'uses' => 'ProductCategoryController@show']);
    });

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