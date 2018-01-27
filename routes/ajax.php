<?php

/**
 * Service
 */
Route::group(['prefix' => 'service'], function() {
    Route::post('start', 'ServiceController@start');
    Route::post('stop', 'ServiceController@stop');
    Route::post('restart', 'ServiceController@restart');
    Route::post('reload', 'ServiceController@reload');
    Route::post('status', 'ServiceController@status');
});

/**
 * System
 */

Route::group(['prefix' => 'data'], function() {
    Route::get('system_users', 'DataController@systemUsers');
    Route::get('database_available_collations', 'DataController@databaseAvailableCollations');
});

/**
 * DNS
 */
Route::group(['prefix' => 'dns'], function() {
    Route::apiResource('zones', 'DnsZoneController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);

    Route::apiResource('records', 'DnsRecordController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);
});

/**
 * Cron
 */
Route::group(['prefix' => 'cron'], function() {
    Route::apiResource('tasks', 'CronController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);
});

/**
 * Database
 */
Route::group(['prefix' => 'database'], function() {
    Route::apiResource('schemas', 'DatabaseSchemaController', [
        'only' => ['index', 'show', 'store', 'destroy']
    ]);
});
