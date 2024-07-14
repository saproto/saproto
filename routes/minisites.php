<?php

use Illuminate\Support\Facades\Route;

$domains = config('proto.domains');

foreach ($domains['smartxp'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', ['uses' => 'SmartXpScreenController@canWork']);
    });
}

foreach ($domains['omnomcom'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', ['uses' => 'OmNomController@miniSite']);
    });
}

foreach ($domains['developers'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', ['as' => 'developers', 'uses' => 'HomeController@developers']);
    });
}

foreach ($domains['isalfredthere'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', ['as' => 'isalfredthere', 'uses' => 'IsAlfredThereController@showMiniSite']);
    });
}

foreach ($domains['static'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::group(['prefix' => 'file', 'as' => 'file::'], static function () {
            Route::get('{id}/{hash}', ['as' => 'get', 'uses' => 'FileController@get']);
            Route::get('{id}/{hash}/{name}', ['uses' => 'FileController@get']);
        });
        Route::group(['prefix' => 'image', 'as' => 'image::'], static function () {
            Route::get('{id}/{hash}', ['as' => 'get', 'uses' => 'FileController@getImage']);
            Route::get('{id}/{hash}/{name}', ['uses' => 'FileController@getImage']);
        });
    });
}
