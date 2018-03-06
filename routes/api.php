<?php

Route::group(['middleware' => ['forcedomain'], 'as' => 'api::'], function () {

    Route::group(['middleware' => ['web']], function () {

        Route::get('photos', ['as' => 'photos::albums', 'uses' => 'PhotoController@apiIndex']);
        Route::get('photos/{id}', ['as' => 'photos::albumList', 'uses' => 'PhotoController@apiShow']);

        Route::group(['prefix' => 'events', 'as' => 'events::'], function () {
            Route::get('upcoming/{limit?}', ['as' => 'upcoming', 'uses' => 'EventController@apiUpcomingEvents']);
            Route::get('', ['as' => 'list', 'uses' => 'EventController@apiEvents']);
            Route::get('{id}', ['as' => 'get', 'uses' => 'EventController@apiEventsSingle']);
            Route::get('{id}/members', ['as' => 'getMembers', 'uses' => 'EventController@apiEventsMembers']);
        });

        Route::group(['prefix' => 'slack', 'as' => 'slack::'], function () {
            Route::get('count', ['as' => 'count', 'uses' => 'SlackController@getOnlineCount']);
            Route::get('invite', ['as' => 'invite', 'middleware' => ['member'], 'uses' => 'SlackController@inviteUser']);
        });

        Route::get('bus/{stop}', ['as' => 'bus', 'uses' => 'SmartXpScreenController@bus']);
        Route::get('timetable', ['as' => 'timetable', 'uses' => 'SmartXpScreenController@timetable']);
        Route::get('timetable/boardroom', ['as' => 'timetable::boardroom', 'uses' => 'SmartXpScreenController@boardroomTimetable']);
        Route::get('timetable/protopeners', ['as' => 'timetable::protopeners', 'uses' => 'SmartXpScreenController@protopenersTimetable']);
        Route::get('timetable/smartxp', ['as' => 'timetable::smartxp', 'uses' => 'SmartXpScreenController@smartxpTimetable']);
        Route::get('members', ['as' => 'members', 'uses' => 'ApiController@members']);
        Route::get('narrowcasting', ['as' => 'narrowcasting', 'uses' => 'NarrowcastingController@indexApi']);

        Route::get('token', ['as' => 'token', 'uses' => 'ApiController@getToken']);

        Route::group(['prefix' => 'protube', 'as' => 'protube::'], function () {
            Route::get('admin/{token}', ['as' => 'admin', 'uses' => 'ApiController@protubeAdmin']);
            Route::get('played', ['as' => 'played', 'uses' => 'ApiController@protubePlayed']);
            Route::get('radiostations', ['uses' => 'RadioController@api']);
            Route::get('displays', ['uses' => 'DisplayController@api']);
            Route::get('sounds', ['as' => 'sounds', 'uses' => 'SoundboardController@apiIndex']);
        });

        Route::get('scan/{event}', ['as' => 'scan', 'middleware' => ['auth'], 'uses' => 'TicketController@scanApi']);

        Route::get('ldapproxy/{personal_key}', ['as' => 'ldapproxy', 'uses' => 'ApiController@ldapProxy']);

        Route::get('protoink', ['as' => 'protoink', 'uses' => 'ProtoInkController@index']);
        Route::get('news', ['as' => 'news', 'uses' => 'NewsController@apiIndex']);

        Route::get('verify_iban', ['as' => 'verify_iban', 'uses' => 'BankController@verifyIban']);

        Route::get('export_data/{table}/{personal_key}', ['as' => 'export', 'uses' => 'ExportController@export']);

        Route::get('dmx_values', ['as', 'dmx_values', 'uses' => 'DmxController@valueApi']);

    });

    Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
        Route::get('info', ['uses' => 'UserApiController@getUser']);
        Route::get('profile_picture', ['uses' => 'UserApiController@getUserProfilePicture']);
        Route::get('address', ['uses' => 'UserApiController@getAddress']);
        Route::get('committees', ['uses' => 'UserApiController@getCommittees']);
        Route::get('achievements', ['uses' => 'UserApiController@getAchievements']);
    });

});