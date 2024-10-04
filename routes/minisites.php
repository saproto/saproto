<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IsAlfredThereController;
use App\Http\Controllers\OmNomController;
use App\Http\Controllers\SmartXpScreenController;
use Illuminate\Support\Facades\Route;

$domains = config('proto.domains');

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

foreach ($domains['static'] as $domain) {
    Route::group(['domain' => $domain], static function () {
        Route::group(['prefix' => 'file', 'as' => 'file::'], static function () {
            Route::get('{id}/{hash}', [FileController::class, 'get'])->name('get');
            Route::get('{id}/{hash}/{name}', [FileController::class, 'get']);
        });
        Route::group(['prefix' => 'image', 'as' => 'image::'], static function () {
            Route::get('{id}/{hash}', [FileController::class, 'getImage'])->name('get');
            Route::get('{id}/{hash}/{name}', [FileController::class, 'getImage']);
        });
    });
}
