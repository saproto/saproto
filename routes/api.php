<?php

Route::group(['middleware' => ['forcedomain'], 'as' => 'api::'], function () {
    /* Routes related to the General APIs */
    Route::group(['middleware' => ['web']], function () {
        Route::get('dmx_values', ['as', 'dmx_values', 'uses' => 'DmxController@valueApi']);
        Route::get('token', ['as' => 'token', 'uses' => 'ApiController@getToken']);
        Route::get('fishcam', ['as' => 'fishcam', 'uses' => 'ApiController@fishcamStream']);
        Route::get('scan/{event}', ['as' => 'scan', 'middleware' => ['auth'], 'uses' => 'TicketController@scanApi']);
        Route::get('news', ['as' => 'news', 'uses' => 'NewsController@apiIndex']);
        Route::get('verify_iban', ['as' => 'verify_iban', 'uses' => 'BankController@verifyIban']);
    });

    /* Routes related to the User API */
    Route::group(['prefix' => 'user', 'as' => 'user::'], function () {
        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('info', ['uses' => 'UserApiController@getUser']);
            Route::get('profile_picture', ['uses' => 'UserApiController@getUserProfilePicture']);
            Route::get('address', ['uses' => 'UserApiController@getAddress']);
            Route::get('committees', ['uses' => 'UserApiController@getCommittees']);
            Route::get('societies', ['uses' => 'UserApiController@getSocieties']);
            Route::get('achievements', ['uses' => 'UserApiController@getAchievements']);
            Route::get('qr_auth_approve/{code}', ['uses' => 'QrAuthController@apiApprove']);
            Route::get('qr_auth_info/{code}', ['uses' => 'QrAuthController@apiInfo']);
            Route::get('token', ['as' => 'token', 'uses' => 'ApiController@getToken']);
            Route::group(['prefix' => 'orders'], function () {
                Route::get('', ['uses' => 'UserApiController@getPurchases']);
                Route::get('total_month', ['uses' => 'UserApiController@getPurchasesMonth']);
                Route::get('next_withdrawal', ['uses' => 'UserApiController@getNextWithdrawal']);
            });
        });
        Route::group(['middleware' => ['web']], function () {
            Route::get('gdpr_export', ['as' => 'gdpr_export', 'middleware' => ['auth'], 'uses' => 'ApiController@gdprExport']);
            Route::get('dev_export/{table}/{personal_key}', ['as' => 'dev_export', 'uses' => 'ExportController@export']);
        });
    });

    /* Routes related to the Events API */
    Route::group(['prefix' => 'events', 'as' => 'events::'], function () {
        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('upcoming/for_user/{limit?}', ['as' => 'list_for_user', 'uses' => 'EventController@apiUpcomingEvents']);
            Route::get('signup/{id}', ['middleware' => ['member'], 'uses' => 'ParticipationController@create']);
            Route::get('signout/{participation_id}', ['middleware' => ['member'], 'uses' => 'ParticipationController@destroy']);
        });
        Route::group(['middleware' => ['web']], function () {
            Route::get('upcoming/{limit?}', ['as' => 'upcoming', 'uses' => 'EventController@apiUpcomingEvents']);
        });
    });

    /* Routes related to the Photos API */
    Route::group(['prefix' => 'photos', 'as' => 'photos::'], function () {
        Route::group(['middleware' => ['web']], function () {
            Route::get('photos', ['as' => 'albums', 'uses' => 'PhotoController@apiIndex']);
            Route::get('photos/{id}', ['as' => 'albumList', 'uses' => 'PhotoController@apiShow']);
        });
        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('photos_api', ['as' => 'albums', 'uses' => 'PhotoController@apiIndex']);
            Route::get('photos_api/{id}', ['as' => 'albumList', 'uses' => 'PhotoController@apiShow']);
        });
    });

    /* Routes related to the Quotes API */
    Route::group(['prefix' => 'quotes', 'as' => 'quotes::', 'middleware' => ['auth:api', 'member']], function () {
        Route::get('', ['as' => 'index', 'uses' => 'QuoteCornerController@overview']);
        Route::post('add', ['as' => 'add', 'uses' => 'QuoteCornerController@add']);
    });

    /* Routes related to the Committees API */
    Route::group(['prefix' => 'committees', 'as' => 'committees::'], function () {
        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('', ['as' => 'index', 'uses' => 'CommitteeController@indexApi']);
        });
        Route::group(['middleware' => ['web']], function () {
            Route::get('unauthenticated', ['as' => 'index', 'uses' => 'CommitteeController@indexApi']);
        });
    });

    Route::group(['prefix' => 'screen', 'as' => 'screen::'], function () {
        Route::get('bus/{stop}', ['as' => 'bus', 'uses' => 'SmartXpScreenController@bus']);
        Route::get('timetable', ['as' => 'timetable', 'uses' => 'SmartXpScreenController@timetable']);
        Route::get('timetable/protopeners', ['as' => 'timetable::protopeners', 'uses' => 'SmartXpScreenController@protopenersTimetable']);
        Route::get('narrowcasting', ['as' => 'narrowcasting', 'uses' => 'NarrowcastingController@indexApi']);
    });

    /* Routes related to the Protube API */
    Route::group(['prefix' => 'protube', 'as' => 'protube::', 'middleware' => ['web']], function () {
        Route::get('admin/{token}', ['as' => 'admin', 'uses' => 'ApiController@protubeAdmin']);
        Route::get('played', ['as' => 'played', 'uses' => 'ApiController@protubePlayed']);
        Route::get('radiostations', ['uses' => 'RadioController@api']);
        Route::get('displays', ['uses' => 'DisplayController@api']);
        Route::get('sounds', ['as' => 'sounds', 'uses' => 'SoundboardController@apiIndex']);
    });

    /* Routes related to the Search API */
    Route::group(['prefix' => 'search', 'as' => 'search::', 'middleware' => ['web', 'auth', 'permission:board|omnomcom']], function () {
        Route::get('user', ['as' => 'user', 'uses' => 'SearchController@getUserSearch']);
        Route::get('committee', ['as' => 'committee', 'uses' => 'SearchController@getCommitteeSearch']);
        Route::get('event', ['as' => 'event', 'uses' => 'SearchController@getEventSearch']);
        Route::get('product', ['as' => 'product', 'uses' => 'SearchController@getProductSearch']);
    });

    /* Route related to the IsAlfredThere API */
    Route::get('isalfredthere', ['as' => 'isalfredthere', 'uses' => 'IsAlfredThereController@getApi']);
});
