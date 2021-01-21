<?php

Route::group(
    [
        'prefix' => 'kodio/messaging',
        'middleware' => 'web',
        'namespace' => 'Kodio\LaravelMessaging\Controllers'
    ],
    function () {

        Route::post('send-message', 'MessagingController@postSendMessage')->name('kodio::laravel-messaging-send-message');
        Route::get('mark-as-readed/{message}', 'MessagingController@getMarkAsReaded')->name('kodio::laravel-messaging-mark-as-readed');
    }
);
