<?php

$domains = config('proto.domains');

foreach ($domains['protube'] as $domain) {
    Route::group(['domain' => $domain, 'as' => 'protube.nl::'], function () {
        Route::get('', ['as' => 'remote', 'uses' => 'ProtubeController@remote']);
        Route::get('screen', ['uses' => 'ProtubeController@screen']);
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
