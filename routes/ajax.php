<?php

Route::group(['prefix' => 'service'], function() {
    Route::post('start', 'ServiceController@start');
    Route::post('stop', 'ServiceController@stop');
    Route::post('restart', 'ServiceController@restart');
    Route::post('reload', 'ServiceController@reload');
    Route::post('status', 'ServiceController@status');
});

Route::group(['prefix' => 'dns'], function() {
    Route::apiResource('zones', 'DnsZoneController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);

    Route::apiResource('records', 'DnsRecordController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);
});
