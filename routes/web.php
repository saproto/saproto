<?php

require 'minisites.php';

/* Pass viewname to body class */
View::composer('*', function ($view) {
    View::share('viewName', $view->getName());
});

Route::group(['middleware' => ['forcedomain']], function () {

    /*
     * The main route for the frontpage.
     */
    Route::get('', ['as' => 'homepage', 'uses' => 'HomeController@show']);
    Route::get('developers', ['uses' => 'HomeController@developers']);
    Route::get('becomeamember', ['as' => 'becomeamember', 'uses' => 'UserDashboardController@becomeAMemberOf']);

    Route::get('fishcam', ['as' => 'fishcam', 'middleware' => ['member'], 'uses' => 'HomeController@fishcam']);

    /*
     * Routes for the search function.
     */
    Route::get('search', ['as' => 'search', 'uses' => 'SearchController@search']);
    Route::post('search', ['as' => 'search', 'uses' => 'SearchController@search']);
    Route::get('opensearch', ['as' => 'search::opensearch', 'uses' => 'SearchController@openSearch']);

    /*
     * Routes for the UTwente addressbook.
     */
    Route::group(['prefix' => 'ldap', 'as' => 'ldap::', 'middleware' => ['utwente']], function () {
        Route::get('search', ['as' => 'search', 'uses' => 'SearchController@ldapSearch']);
        Route::post('search', ['as' => 'search', 'uses' => 'SearchController@ldapSearch']);
    });

    /*
     * Routes related to authentication.
     */
    Route::group(['as' => 'login::'], function () {
        Route::get('login', ['as' => 'show', 'uses' => 'AuthController@getLogin']);
        Route::post('login', ['as' => 'post', 'uses' => 'AuthController@postLogin']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

        Route::get('password/reset/{token}', ['as' => 'resetpass::token', 'uses' => 'AuthController@getReset']);
        Route::post('password/reset', ['as' => 'resetpass::submit', 'uses' => 'AuthController@postReset']);

        Route::get('password/email', ['as' => 'resetpass', 'uses' => 'AuthController@getEmail']);
        Route::post('password/email', ['as' => 'resetpass::send', 'uses' => 'AuthController@postEmail']);

        Route::get('password/sync', ['as' => 'password::sync', 'middleware' => ['auth'], 'uses' => 'AuthController@passwordSyncGet']);
        Route::post('password/sync', ['as' => 'password::sync', 'middleware' => ['auth'], 'uses' => 'AuthController@passwordSyncPost']);

        Route::get('password/change', ['as' => 'password::change', 'middleware' => ['auth'], 'uses' => 'AuthController@passwordChangeGet']);
        Route::post('password/change', ['as' => 'password::change', 'middleware' => ['auth'], 'uses' => 'AuthController@passwordChangePost']);

        Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
        Route::post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
        Route::post('register/surfconext', ['as' => 'register::surfconext', 'uses' => 'AuthController@postRegisterSurfConext']);

        Route::get('surfconext', ['as' => 'edu', 'uses' => 'AuthController@startSurfConextAuth']);
        Route::get('surfconext/post', ['as' => 'edupost', 'uses' => 'AuthController@surfConextAuthPost']);

        Route::get('username', ['as' => 'requestusername', 'uses' => 'AuthController@requestUsername']);
        Route::post('username', ['as' => 'requestusername', 'uses' => 'AuthController@requestUsername']);
    });

    /*
     * Routes related to user profiles.
     */
    Route::group(['prefix' => 'user', 'as' => 'user::', 'middleware' => ['auth']], function () {

        Route::post('delete/{id}', ['as' => 'delete', 'uses' => 'AuthController@deleteUser']);
        Route::post('password', ['as' => 'changepassword', 'uses' => 'AuthController@updatePassword']);

        Route::get('personal_key/{id}', ['as' => 'personal_key::generate', 'uses' => 'UserDashboardController@generateKey']);

        /*
         * Routes related to members.
         */
        Route::group(['prefix' => '{id}/member', 'as' => 'member::', 'middleware' => ['auth', 'permission:board']], function () {
            Route::get('impersonate', ['as' => 'impersonate', 'middleware' => ['auth', 'permission:board'], 'uses' => 'UserAdminController@impersonate']);

            Route::post('add', ['as' => 'add', 'uses' => 'UserAdminController@addMembership']);
            Route::post('remove', ['as' => 'remove', 'uses' => 'UserAdminController@endMembership']);
        });

        Route::group(['prefix' => 'memberprofile', 'as' => 'memberprofile::', 'middleware' => ['auth']], function () {
            Route::get('complete', ['as' => 'complete', 'uses' => 'UserDashboardController@getCompleteProfile']);
            Route::post('complete', ['as' => 'complete', 'uses' => 'UserDashboardController@postCompleteProfile']);
            Route::get('clear', ['as' => 'clear', 'uses' => 'UserDashboardController@getClearProfile']);
            Route::post('clear', ['as' => 'clear', 'uses' => 'UserDashboardController@postClearProfile']);
        });

        Route::group(['prefix' => 'admin', 'as' => 'admin::', 'middleware' => ['auth', 'permission:board']], function () {
            Route::get('', ['as' => 'list', 'uses' => 'UserAdminController@index']);
            Route::get('details/{id}', ['as' => 'details', 'uses' => 'UserAdminController@details']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserAdminController@update']);
            Route::get('restore/{id}', ['as' => 'restore', 'uses' => 'UserAdminController@restorePage']);
            Route::post('restore/{id}', ['as' => 'restore', 'uses' => 'UserAdminController@restorePost']);

            Route::get('nda/{id}', ['as' => 'toggle_nda', 'middleware' => ['permission:sysadmin'], 'uses' => 'UserAdminController@toggleNda']);
        });

        Route::get('quit_impersonating', ['as' => 'quitimpersonating', 'uses' => 'UserAdminController@quitImpersonating']);

        Route::get('dashboard/{id?}', ['as' => 'dashboard', 'uses' => 'UserDashboardController@show']);
        Route::post('dashboard/{id?}', ['as' => 'dashboard', 'uses' => 'UserDashboardController@update']);

        Route::get('{id?}', ['as' => 'profile', 'middleware' => ['member'], 'uses' => 'UserProfileController@show']);

        /*
         * Routes related to addresses.
         */
        Route::group(['prefix' => '{id}/address', 'as' => 'address::'], function () {
            Route::get('add', ['as' => 'add', 'uses' => 'AddressController@addForm']);
            Route::post('add', ['as' => 'add', 'uses' => 'AddressController@add']);
            Route::get('delete', ['as' => 'delete', 'uses' => 'AddressController@delete']);
            Route::get('edit', ['as' => 'edit', 'uses' => 'AddressController@editForm']);
            Route::post('edit', ['as' => 'edit', 'uses' => 'AddressController@edit']);
            Route::get('togglehidden', ['as' => 'togglehidden', 'uses' => 'AddressController@toggleHidden']);
        });

        /*
         * Routes related to diet.
         */
        Route::group(['prefix' => '{id}/diet', 'as' => 'diet::'], function () {
            Route::post('edit', ['as' => 'edit', 'uses' => 'UserDashboardController@editDiet']);
        });

        /*
         * Routes related to bank accounts
         */
        Route::group(['prefix' => '{id}/bank', 'as' => 'bank::'], function () {
            Route::get('add', ['as' => 'add', 'uses' => 'BankController@addForm']);
            Route::post('add', ['as' => 'add', 'uses' => 'BankController@add']);
            Route::post('delete', ['as' => 'delete', 'uses' => 'BankController@delete']);
            Route::get('edit', ['as' => 'edit', 'uses' => 'BankController@editForm']);
            Route::post('edit', ['as' => 'edit', 'uses' => 'BankController@edit']);
        });

        /*
         * Routes related to RFID cards
         */
        Route::group(['prefix' => 'rfidcard/{id}', 'as' => 'rfid::'], function () {
            Route::get('delete', ['as' => 'delete', 'uses' => 'RfidCardController@destroy']);
            Route::get('edit', ['as' => 'edit', 'uses' => 'RfidCardController@edit']);
            Route::post('edit', ['as' => 'edit', 'uses' => 'RfidCardController@update']);
        });

        /*
         * Routes related to profile pictures
         */
        Route::group(['prefix' => '{id}/profilepic', 'as' => 'pic::'], function () {
            Route::post('update', ['as' => 'update', 'uses' => 'ProfilePictureController@update']);
            Route::get('delete', ['as' => 'delete', 'uses' => 'ProfilePictureController@destroy']);
        });


        /*
         * Routes related to UT accounts
         */
        Route::group(['prefix' => '{id}/edu', 'as' => 'edu::'], function () {
            Route::get('delete', ['as' => 'delete', 'uses' => 'SurfConextController@destroy']);
            Route::get('add', ['as' => 'add', 'uses' => 'SurfConextController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'SurfConextController@store']);
        });

        /*
         * Routes related to studies
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
        });
    });

    Route::post('memberform/print', ['as' => 'memberform::print', 'middleware' => ['auth', 'permission:board'], 'uses' => 'UserAdminController@printForm']);
    Route::get('memberform/{id}', ['as' => 'memberform::download', 'uses' => 'UserAdminController@showForm']);

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

        Route::get('{id}/send_anonymous_email', ['as' => 'anonymousmail', 'middleware' => ['auth', 'member'], 'uses' => 'CommitteeController@showAnonMailForm']);
        Route::post('{id}/send_anonymous_email', ['as' => 'anonymousmail', 'middleware' => ['auth', 'member'], 'uses' => 'CommitteeController@postAnonMailForm']);

        Route::get('{id}/edit', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@editForm']);
        Route::post('{id}/edit', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@edit']);

        Route::post('{id}/image', ['as' => 'image', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CommitteeController@image']);

    });

    /*
     * Routes related to narrowcasting.
     */
    Route::group(['prefix' => 'narrowcasting', 'as' => 'narrowcasting::'], function () {

        Route::get('', ['as' => 'display', 'uses' => 'NarrowcastingController@display']);
        Route::get('list', ['as' => 'list', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@index']);
        Route::get('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@create']);
        Route::post('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@destroy']);
        Route::get('clear', ['as' => 'clear', 'middleware' => ['auth', 'permission:board'], 'uses' => 'NarrowcastingController@clear']);

    });

    /*
     * Routes related to companies.
     */
    Route::group(['prefix' => 'companies', 'as' => 'companies::'], function () {

        Route::get('list', ['as' => 'admin', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@adminIndex']);
        Route::get('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@create']);
        Route::post('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@destroy']);

        Route::get('up/{id}', ['as' => 'orderUp', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@orderUp']);
        Route::get('down/{id}', ['as' => 'orderDown', 'middleware' => ['auth', 'permission:board'], 'uses' => 'CompanyController@orderDown']);

        Route::get('', ['as' => 'index', 'uses' => 'CompanyController@index']);
        Route::get('{id}', ['as' => 'show', 'uses' => 'CompanyController@show']);

    });

    /*
     * Routes related to membercard.
     */
    Route::group(['prefix' => 'membercard', 'as' => 'membercard::'], function () {

        Route::get('', ['as' => 'index', 'uses' => 'CompanyController@indexmembercard']);

        Route::post('print', ['as' => 'print', 'middleware' => ['auth', 'permission:board'], 'uses' => 'MemberCardController@startprint']);
        Route::post('printoverlay', ['as' => 'printoverlay', 'middleware' => ['auth', 'permission:board'], 'uses' => 'MemberCardController@startoverlayprint']);
        Route::get('download/{id}', ['as' => 'download', 'uses' => 'MemberCardController@download']);

        Route::get('{id}', ['as' => 'show', 'uses' => 'CompanyController@showmembercard']);

    });

    /*
     * Routes related to joboffers.
     */
    Route::group(['prefix' => 'joboffers', 'as' => 'joboffers::'], function () {

        Route::get('', ['as' => 'index', 'uses' => 'JobofferController@index']);
        Route::get('list', ['as' => 'admin', 'middleware' => ['auth', 'permission:board'], 'uses' => 'JobofferController@adminIndex']);

        Route::get('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'JobofferController@create']);
        Route::post('add', ['as' => 'add', 'middleware' => ['auth', 'permission:board'], 'uses' => 'JobofferController@store']);

        Route::get('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'JobofferController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'middleware' => ['auth', 'permission:board'], 'uses' => 'JobofferController@update']);

        Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['auth', 'permission:board'], 'uses' => 'JobofferController@destroy']);

        Route::get('{id}', ['as' => 'show', 'uses' => 'JobofferController@show']);

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

        Route::post('album/{event}/link', ['as' => 'linkalbum', 'middleware' => ['permission:board'], 'uses' => 'EventController@linkAlbum']);
        Route::get('album/unlink/{album}', ['as' => 'unlinkalbum', 'middleware' => ['permission:board'], 'uses' => 'EventController@unlinkAlbum']);

        Route::get('admin/{id}', ['as' => 'admin', 'middleware' => ['auth'], 'uses' => 'EventController@admin']);
        Route::get('scan/{id}', ['as' => 'scan', 'middleware' => ['auth'], 'uses' => 'EventController@scan']);

        Route::get('checklist/{id}', ['as' => 'checklist', 'uses' => 'ActivityController@checklist']);

        Route::get('archive/{year}', ['as' => 'archive', 'uses' => 'EventController@archive']);

        // Related to presence
        Route::get('togglepresence/{id}', ['as' => 'togglepresence', 'middleware' => ['auth'], 'uses' => 'ParticipationController@togglePresence']);

        // Related to participation
        Route::get('participate/{id}', ['as' => 'addparticipation', 'middleware' => ['member'], 'uses' => 'ParticipationController@create']);
        Route::get('unparticipate/{participation_id}', ['as' => 'deleteparticipation', 'uses' => 'ParticipationController@destroy']);

        Route::post('participatefor/{id}', ['as' => 'addparticipationfor', 'middleware' => ['permission:board'], 'uses' => 'ParticipationController@createFor']);

        // Related to activities
        Route::post('signup/{id}', ['as' => 'addsignup', 'middleware' => ['permission:board'], 'uses' => 'ActivityController@save']);
        Route::get('signup/{id}/delete', ['as' => 'deletesignup', 'middleware' => ['permission:board'], 'uses' => 'ActivityController@delete']);

        // Related to helping committees
        Route::post('addhelp/{id}', ['as' => 'addhelp', 'middleware' => ['permission:board'], 'uses' => 'ActivityController@addHelp']);
        Route::get('deletehelp/{id}', ['as' => 'deletehelp', 'middleware' => ['permission:board'], 'uses' => 'ActivityController@deleteHelp']);

        // Buy tickets for an event
        Route::post('buytickets/{id}', ['as' => 'buytickets', 'middleware' => ['auth'], 'uses' => 'TicketController@buyForEvent']);

        // Show event
        Route::get('{id}', ['as' => 'show', 'uses' => 'EventController@show']);

    });

    Route::group(['prefix' => 'newsletter', 'as' => 'newsletter::'], function () {
        Route::get('', ['as' => 'preview', 'middleware' => ['auth'], 'uses' => 'NewsletterController@newsletterPreview']);
        Route::group(['middleware' => ['permission:board']], function () {
            Route::get('content', ['as' => 'show', 'uses' => 'NewsletterController@getInNewsletter']);
            Route::get('toggle/{id}', ['as' => 'toggle', 'uses' => 'NewsletterController@toggleInNewsletter']);
            Route::post('send', ['as' => 'send', 'uses' => 'NewsletterController@sendNewsletter']);
        });
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
     * Routes related to pages.
     */
    Route::group(['prefix' => 'news', 'as' => 'news::'], function () {

        Route::group(['middleware' => ['auth', 'permission:board']], function () {
            Route::get('admin', ['as' => 'admin', 'uses' => 'NewsController@admin']);
            Route::get('add', ['as' => 'add', 'uses' => 'NewsController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'NewsController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'NewsController@edit']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'NewsController@update']);
            Route::post('edit/{id}/image', ['as' => 'image', 'uses' => 'NewsController@featuredImage']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'NewsController@destroy']);
        });

        Route::get('', ['as' => 'list', 'uses' => 'NewsController@index']);
        Route::get('{id}', ['as' => 'show', 'uses' => 'NewsController@show']);

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
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'MenuController@update']);
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

    /*
     * Routes related to tickets.
     */
    Route::group(['prefix' => 'tickets', 'middleware' => ['auth'], 'as' => 'tickets::'], function () {

        Route::group(['middleware' => ['auth', 'permission:board']], function () {
            Route::get('', ['as' => 'list', 'uses' => 'TicketController@index']);
            Route::get('add', ['as' => 'add', 'uses' => 'TicketController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'TicketController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TicketController@edit']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'TicketController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'TicketController@destroy']);
        });

        Route::get('scan/{barcode}', ['as' => 'scan', 'uses' => 'TicketController@scan']);
        Route::get('unscan/{barcode}', ['as' => 'unscan', 'uses' => 'TicketController@unscan']);
        Route::get('download/{id}', ['as' => 'download', 'uses' => 'TicketController@download']);

    });

    /*
     * Routes related to courses
     */
    Route::group(['prefix' => 'course', 'as' => 'course::', 'middleware' => ['auth']], function () {
        Route::get('', ['as' => 'list', 'uses' => 'CourseController@index']);

        Route::group(['middleware' => ['permission:board']], function () {
            Route::get('add', ['as' => 'add', 'uses' => 'CourseController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'CourseController@store']);

            Route::get('{id}/delete', ['as' => 'delete', 'uses' => 'CourseController@destroy']);
        });
    });

    /*
     * Routes related to e-mail.
     */
    Route::get('togglelist/{id}/{user_id}', ['as' => 'togglelist', 'middleware' => ['auth'], 'uses' => 'EmailListController@toggleSubscription']);

    Route::get('unsubscribe/{hash}', ['as' => 'unsubscribefromlist', 'uses' => 'EmailController@unsubscribeLink']);

    Route::group(['prefix' => 'email', 'middleware' => ['auth', 'permission:board'], 'as' => 'email::'], function () {

        Route::get('', ['as' => 'admin', 'uses' => 'EmailController@index']);

        Route::group(['prefix' => 'list', 'as' => 'list::'], function () {

            Route::get('add', ['as' => 'add', 'uses' => 'EmailListController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'EmailListController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EmailListController@edit']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'EmailListController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'EmailListController@destroy']);

        });

        Route::get('add', ['as' => 'add', 'uses' => 'EmailController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'EmailController@store']);
        Route::get('preview/{id}', ['as' => 'show', 'uses' => 'EmailController@show']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EmailController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'EmailController@update']);
        Route::get('toggleready/{id}', ['as' => 'toggleready', 'uses' => 'EmailController@toggleReady']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'EmailController@destroy']);

        Route::group(['prefix' => '{id}/attachment', 'as' => 'attachment::'], function () {
            Route::post('add', ['as' => 'add', 'uses' => 'EmailController@addAttachment']);
            Route::get('delete/{file_id}', ['as' => 'delete', 'uses' => 'EmailController@deleteAttachment']);
        });

    });

    /*
     * Routes related to the Quote Corner.
     */
    Route::group(['prefix' => 'quotes', 'middleware' => ['member'], 'as' => 'quotes::'], function () {
        Route::get('', ['as' => 'list', 'uses' => 'QuoteCornerController@overview']);
        Route::post('add', ['as' => 'add', 'uses' => 'QuoteCornerController@add']);
        Route::get('delete/{id}', ['as' => 'delete', 'middleware' => ['permission:board'], 'uses' => 'QuoteCornerController@delete']);
        Route::get('like/{id}', ['as' => 'like', 'uses' => 'QuoteCornerController@toggleLike']);
    });

    /*
     * Routes related to the OmNomCom.
     */
    Route::group(['prefix' => 'omnomcom', 'as' => 'omnomcom::'], function () {

        Route::get('minisite', ['uses' => 'OmNomController@miniSite']);

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

        Route::group(['prefix' => 'tipcie', 'middleware' => ['auth', 'permission:tipcie|omnomcom'], 'as' => 'tipcie::'], function () {
            Route::get('', ['as' => 'orderhistory', 'uses' => 'TIPCieController@orderIndex']);
        });

        Route::group(['prefix' => 'accounts', 'middleware' => ['permission:finadmin'], 'as' => 'accounts::'], function () {
            Route::get('', ['as' => 'list', 'uses' => 'AccountController@index']);
            Route::get('add', ['as' => 'add', 'uses' => 'AccountController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'AccountController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'AccountController@edit']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'AccountController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'AccountController@destroy']);
            Route::get('{id}', ['as' => 'show', 'uses' => 'AccountController@show']);
            Route::post('aggregate/{account}', ['as' => 'aggregate', 'uses' => 'AccountController@showAggregation']);
        });

        Route::group(['prefix' => 'products', 'middleware' => ['permission:omnomcom'], 'as' => 'products::'], function () {
            Route::get('', ['as' => 'list', 'uses' => 'ProductController@index']);
            Route::get('add', ['as' => 'add', 'uses' => 'ProductController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'ProductController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProductController@edit']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'ProductController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ProductController@destroy']);

            Route::get('export/csv', ['as' => 'export_csv', 'uses' => 'ProductController@generateCsv']);

            Route::get('statistics', ['as' => 'statistics', 'uses' => 'AccountController@showOmnomcomStatistics']);
            Route::post('statistics', ['as' => 'statistics', 'uses' => 'AccountController@showOmnomcomStatistics']);

            Route::get('{id}', ['as' => 'show', 'uses' => 'ProductController@show']);

            Route::post('update/bulk', ['as' => 'bulkupdate', 'middleware' => ['permission:omnomcom'], 'uses' => 'ProductController@bulkUpdate']);
            Route::get('rank/{category}/{product}/{direction}', ['as' => 'rank', 'middleware' => ['permission:omnomcom'], 'uses' => 'ProductController@rank']);
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

        Route::group(['prefix' => 'withdrawals', 'middleware' => ['permission:finadmin'], 'as' => 'withdrawal::'], function () {
            Route::get('', ['as' => 'list', 'uses' => 'WithdrawalController@index']);
            Route::get('add', ['as' => 'add', 'uses' => 'WithdrawalController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'WithdrawalController@store']);
            Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'WithdrawalController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'WithdrawalController@destroy']);
            Route::get('{id}', ['as' => 'show', 'uses' => 'WithdrawalController@show']);
            Route::get('accounts/{id}', ['as' => 'showAccounts', 'uses' => 'WithdrawalController@showAccounts']);

            Route::get('export/{id}', ['as' => 'export', 'uses' => 'WithdrawalController@export']);
            Route::get('close/{id}', ['as' => 'close', 'uses' => 'WithdrawalController@close']);
            Route::get('email/{id}', ['as' => 'email', 'uses' => 'WithdrawalController@email']);

            Route::get('deletefrom/{id}/{user_id}', ['as' => 'deleteuser', 'uses' => 'WithdrawalController@deleteFrom']);
        });

        Route::get('unwithdrawable', ['middleware' => ['permission:finadmin'], 'as' => 'unwithdrawable', 'uses' => 'WithdrawalController@unwithdrawable']);

        Route::group(['prefix' => 'mollie', 'middleware' => ['auth'], 'as' => 'mollie::'], function () {
            Route::post('pay', ['as' => 'pay', 'uses' => 'MollieController@pay']);
            Route::get('status/{id}', ['as' => 'status', 'uses' => 'MollieController@status']);
            Route::get('receive/{id}', ['as' => 'receive', 'uses' => 'MollieController@receive']);
            Route::get('list', ['as' => 'list', 'middleware' => ['permission:finadmin'], 'uses' => 'MollieController@index']);
            Route::get('monthly/{month}', ['as' => 'monthly', 'middleware' => ['permission:finadmin'], 'uses' => 'MollieController@monthly']);
        });

        Route::get('mywithdrawal/{id}', ['as' => 'mywithdrawal', 'middleware' => ['auth'], 'uses' => 'WithdrawalController@showForUser']);

        Route::get('supplier', ['as' => 'generateorder', 'middleware' => ['permission:omnomcom'], 'uses' => 'OmNomController@generateOrder']);

    });

    /*
     * Routes related to webhooks.
     */
    Route::group(['prefix' => 'webhook', 'as' => 'webhook::'], function () {
        Route::any('mollie/{id}', ['as' => 'mollie', 'uses' => 'MollieController@webhook']);
    });

    /**
     * Routes related to printing.
     */
    Route::group(['prefix' => 'print', 'middleware' => ['member'], 'as' => 'print::'], function () {
        Route::get('', ['as' => 'form', 'uses' => 'PrintController@form']);
        Route::post('', ['as' => 'print', 'uses' => 'PrintController@doPrint']);
    });

    /*
     * Routes related to Flickr photos.
     */
    Route::group(['prefix' => 'photos', 'as' => 'photo::'], function () {
        Route::get('', ['as' => 'albums', 'uses' => 'PhotoController@index']);
        Route::get('slideshow', ['as' => 'slideshow', 'uses' => 'PhotoController@slideshow']);

        Route::group(['prefix' => '{id}', 'as' => 'album::'], function () {
            Route::get('', ['as' => 'list', 'uses' => 'PhotoController@show']);
        });
    });
    Route::group(['prefix' => 'flickr', 'as' => 'flickr::'], function () {
        Route::get('oauth', ['as' => 'oauth', 'middleware' => ['auth', 'permission:board'], 'uses' => 'FlickrController@oauthTool']);
    });

    /*
     * Routes related to Spotify
     */
    Route::group(['prefix' => 'spotify', 'middleware' => ['auth', 'permission:board'], 'as' => 'spotify::'], function () {
        Route::get('oauth', ['as' => 'oauth', 'uses' => 'SpotifyController@oauthTool']);
    });

    /*
     * Routes related to roles and permissions.
     */
    Route::group(['prefix' => 'authorization', 'middleware' => ['auth', 'permission:sysadmin'], 'as' => 'authorization::'], function () {
        Route::get('', ['as' => 'overview', 'uses' => 'AuthorizationController@index']);
        Route::post('{id}/grant', ['as' => 'grant', 'uses' => 'AuthorizationController@grant']);
        Route::get('{id}/revoke/{user}', ['as' => 'revoke', 'uses' => 'AuthorizationController@revoke']);
    });

    /*
     * Routes related to the password manager.
     */
    Route::group(['prefix' => 'passwordstore', 'middleware' => ['auth'], 'as' => 'passwordstore::'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'PasswordController@index']);
        Route::get('auth', ['as' => 'auth', 'uses' => 'PasswordController@getAuth']);
        Route::post('auth', ['as' => 'auth', 'uses' => 'PasswordController@postAuth']);
        Route::get('add', ['as' => 'add', 'uses' => 'PasswordController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'PasswordController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PasswordController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'PasswordController@update']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'PasswordController@destroy']);
    });

    /*
     * Routes related to e-mail aliases.
     */
    Route::group(['prefix' => 'alias', 'middleware' => ['auth', 'permission:sysadmin'], 'as' => 'alias::'], function () {
        Route::get('', ['as' => 'index', 'uses' => 'AliasController@index']);
        Route::get('add', ['as' => 'add', 'uses' => 'AliasController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'AliasController@store']);
        Route::get('delete/{idOrAlias}', ['as' => 'delete', 'uses' => 'AliasController@destroy']);
        Route::post('update', ['as' => 'update', 'uses' => 'AliasController@update']);
    });

    /*
     * The route for the SmartXp Screen.
     */
    Route::get('smartxp', ['as' => 'smartxp', 'uses' => 'SmartXpScreenController@show']);
    Route::get('caniworkinthesmartxp', ['uses' => 'SmartXpScreenController@canWork']);
    Route::get('boardroom', ['uses' => 'SmartXpScreenController@boardroomStatus']);

    /*
     * The routes for Protube.
     */
    Route::group(['prefix' => 'protube', 'as' => 'protube::'], function () {
        Route::get('screen', ['as' => 'screen', 'uses' => 'ProtubeController@screen']);
        Route::get('admin', ['as' => 'admin', 'middleware' => ['auth'], 'uses' => 'ProtubeController@admin']);
        Route::get('offline', ['as' => 'offline', 'uses' => 'ProtubeController@offline']);
        Route::get('dashboard', ['as' => 'dashboard', 'middleware' => ['auth'], 'uses' => 'ProtubeController@dashboard']);
        Route::get('togglehistory', ['as' => 'togglehistory', 'middleware' => ['auth'], 'uses' => 'ProtubeController@toggleHistory']);
        Route::get('clearhistory', ['as' => 'clearhistory', 'middleware' => ['auth'], 'uses' => 'ProtubeController@clearHistory']);
        Route::get('top', ['as' => 'top', 'uses' => 'ProtubeController@topVideos']);
        Route::get('{id?}', ['as' => 'remote', 'uses' => 'ProtubeController@remote']);

        Route::group(['prefix' => 'radio', 'middleware' => ['permission:admin'], 'as' => 'radio::'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'RadioController@index']);
            Route::post('store', ['as' => 'store', 'uses' => 'RadioController@store']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'RadioController@destroy']);
        });

        Route::group(['prefix' => 'display', 'middleware' => ['permission:admin'], 'as' => 'display::'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'DisplayController@index']);
            Route::post('store', ['as' => 'store', 'uses' => 'DisplayController@store']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'DisplayController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'DisplayController@destroy']);
        });

        Route::group(['prefix' => 'soundboard', 'middleware' => ['permission:admin'], 'as' => 'soundboard::'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'SoundboardController@index']);
            Route::post('store', ['as' => 'store', 'uses' => 'SoundboardController@store']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'SoundboardController@destroy']);
            Route::get('togglehidden/{id}', ['as' => 'togglehidden', 'uses' => 'SoundboardController@toggleHidden']);
        });
    });

    /*
     * Routes related to calendars.
     */
    Route::group(['prefix' => 'ical', 'as' => 'ical::'], function () {
        Route::get('calendar', ['as' => 'calendar', 'uses' => 'EventController@icalCalendar']);
    });

    /*
     * Routes related to the Achievement system.
     */
    Route::group(['prefix' => 'achievement', 'as' => 'achievement::'], function () {
        Route::group(['middleware' => ['auth', 'permission:board']], function () {
            Route::get('', ['as' => 'list', 'uses' => 'AchievementController@overview']);
            Route::get('add', ['as' => 'add', 'uses' => 'AchievementController@create']);
            Route::post('add', ['as' => 'add', 'uses' => 'AchievementController@store']);
            Route::get('manage/{id}', ['as' => 'manage', 'uses' => 'AchievementController@manage']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'AchievementController@update']);
            Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'AchievementController@destroy']);
            Route::post('give/{id}', ['as' => 'give', 'uses' => 'AchievementController@give']);
            Route::get('take/{id}/{user}', ['as' => 'take', 'uses' => 'AchievementController@take']);
            Route::get('takeAll/{id}', ['as' => 'takeAll', 'uses' => 'AchievementController@takeAll']);
            Route::post('{id}/icon', ['as' => 'icon', 'uses' => 'AchievementController@icon']);
        });
        Route::get('gallery', ['as' => 'gallery', 'uses' => 'AchievementController@gallery']);
    });

    /*
     * Routes related to the welcome message system.
     */
    Route::group(['prefix' => 'welcomeMessages', 'middleware' => ['auth', 'permission:board'], 'as' => 'welcomeMessages::'], function () {
        Route::get('', ['as' => 'list', 'uses' => 'WelcomeController@overview']);
        Route::post('add', ['as' => 'add', 'uses' => 'WelcomeController@store']);
        Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'WelcomeController@destroy']);
    });

    /*
     * Tempadmin
     */
    Route::group(['prefix' => 'tempadmin', 'as' => 'tempadmin::', 'middleware' => ['auth', 'permission:board']], function () {
        Route::get('make/{id}', ['as' => 'make', 'uses' => 'TempAdminController@make']);
        Route::get('end/{id}', ['as' => 'end', 'uses' => 'TempAdminController@end']);
        Route::get('endId/{id}', ['as' => 'endId', 'uses' => 'TempAdminController@endId']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TempAdminController@edit']);
        Route::post('edit/{id}', ['as' => 'edit', 'uses' => 'TempAdminController@update']);
        Route::get('add', ['as' => 'add', 'uses' => 'TempAdminController@create']);
        Route::post('add', ['as' => 'add', 'uses' => 'TempAdminController@store']);
        Route::get('', ['as' => 'index', 'uses' => 'TempAdminController@index']);
    });

    /*
     * QR Auth
     */
    Route::group(['prefix' => 'qr', 'as' => 'qr::'], function () {

        Route::get('code/{code}', ['as' => 'code', 'uses' => 'QrAuthController@showCode']);
        Route::post('generate', ['as' => 'generate', 'uses' => 'QrAuthController@generateRequest']);
        Route::get('isApproved', ['as' => 'approved', 'uses' => 'QrAuthController@isApproved']);

        Route::group(['middleware' => ['auth']], function () {
            Route::get('{code}', ['as' => 'dialog', 'uses' => 'QrAuthController@showDialog']);
            Route::get('{code}/approve', ['as' => 'approve', 'uses' => 'QrAuthController@approve']);
        });

    });

    /*
     * DMX Management
     */
    Route::group(['prefix' => 'dmx', 'as' => 'dmx::', 'middleware' => ['auth', 'permission:sysadmin|alfred']], function () {

        Route::get('/', ['as' => 'index', 'uses' => 'DmxController@index']);
        Route::get('/add', ['as' => 'add', 'uses' => 'DmxController@create']);
        Route::post('/add', ['as' => 'add', 'uses' => 'DmxController@store']);
        Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'DmxController@edit']);
        Route::post('/edit/{id}', ['as' => 'edit', 'uses' => 'DmxController@update']);
        Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'DmxController@delete']);

    });

    Route::get('phototest/{id}', ['uses' => 'FlickrController@getPhoto']);

});
