<?php

$domains = config('proto.domains');

foreach ($domains['protube'] as $domain) {
    Route::group(array('domain' => $domain), function () {
        Route::get('', ['uses' => 'ProtubeController@remote']);
        Route::get('screen', ['uses' => 'ProtubeController@screen']);
        Route::get('admin', ['middleware' => ['auth'], 'uses' => 'ProtubeController@admin']);
        Route::get('offline', ['uses' => 'ProtubeController@offline']);
    });
}

foreach ($domains['smartxp'] as $domain) {
    Route::group(array('domain' => $domain), function () {
        Route::get('', ['uses' => 'SmartXpScreenController@canWork']);
    });
}

foreach ($domains['omnomcom'] as $domain) {
    Route::group(array('domain' => $domain), function () {
        Route::get('', ['uses' => 'OmNomController@miniSite']);
    });
}

foreach ($domains['developers'] as $domain) {
    Route::group(array('domain' => $domain), function () {
        Route::get('', ['uses' => 'HomeController@developers']);
    });
}
