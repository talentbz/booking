<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

Route::group(['prefix' => Config::get('awebooking.prefix_dashboard'), 'middleware' => ['authenticate', 'locale']], function () {

    Route::get('messenger/{code?}', 'ChatController@_messenger')->name('messenger');

    Route::post('messenger/messenger-post', 'ChatController@_messengerPost')->name('messenger-post');

    Route::post('messenger/refresh-message', 'ChatController@_refreshMessage')->name('refresh-message');

    Route::post('messenger/refresh-channel', 'ChatController@_refreshChannel')->name('refresh-channel');

    Route::post('messenger/save-settings', 'ChatController@_saveSettings')->name('save-settings');

    Route::post('messenger/translator', 'ChatController@_translator')->name('translator');

    Route::post('messenger/update-flag', 'ChatController@updateFlag')->name('update-flag');
});

Route::post('messenger/start-message', 'ChatController@_startMessage')->name('start-message');
