<?php

$domains = config('proto.domains');

foreach ($domains['protube'] as $domain) {
    Route::group(['domain' => $domain, 'as' => 'protube.nl::'], function () {
        Route::get('screen', ['uses' => 'ProtubeController@screen']);
        Route::get('{id?}', ['as' => 'remote', 'uses' => 'ProtubeController@remote']);
    });
}

foreach ($domains['smartxp'] as $domain) {
    Route::group(['domain' => $domain], function () {
        Route::get('', ['uses' => 'SmartXpScreenController@canWork']);
    });
}

foreach ($domains['omnomcom'] as $domain) {
    Route::group(['domain' => $domain], function () {
        Route::get('', ['uses' => 'OmNomController@miniSite']);
    });
}

foreach ($domains['developers'] as $domain) {
    Route::group(['domain' => $domain], function () {
        Route::get('', ['as' => 'developers', 'uses' => 'HomeController@developers']);
    });
}

foreach ($domains['isalfredthere'] as $domain) {
    Route::group(['domain' => $domain], function () {
        Route::get('', ['as' => 'isalfredthere', 'uses' => 'IsAlfredThereController@showMiniSite']);
    });
}