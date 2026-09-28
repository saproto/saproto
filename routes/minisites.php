<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IsAlfredThereController;
use App\Http\Controllers\OmNomController;
use App\Http\Controllers\SmartXpScreenController;
use App\Http\Controllers\WrappedController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

$domains = Config::array('proto.domains');

foreach ($domains['smartxp'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', [SmartXpScreenController::class, 'canWork']);
    });
}

foreach ($domains['omnomcom'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', [OmNomController::class, 'miniSite']);
    });
}

foreach ($domains['wrapped'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', [WrappedController::class, 'index'])->middleware('auth');
    });
}

foreach ($domains['developers'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', [HomeController::class, 'developers']);
    });
}

foreach ($domains['isalfredthere'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::get('', [IsAlfredThereController::class, 'index']);
    });
}
