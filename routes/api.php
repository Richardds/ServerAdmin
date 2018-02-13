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
 * Data (Enums, etc...)
 */

Route::group(['prefix' => 'data'], function() {
    Route::get('system_users', 'DataController@systemUsers');
    Route::get('database_available_character_sets', 'DataController@databaseAvailableCharacterSets');
    Route::get('database_available_collations', 'DataController@databaseAvailableCollations');
    Route::get('database_users', 'DataController@databaseUsers');
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
    Route::patch('grant', 'DatabaseUserController@grantPrivileges');
    Route::patch('revoke', 'DatabaseUserController@revokePrivileges');
    Route::patch('userPassword', 'DatabaseUserController@changePassword');
    Route::apiResource('schemas', 'DatabaseSchemaController', [
        'only' => ['index', 'show', 'store', 'destroy']
    ]);
    Route::apiResource('users', 'DatabaseUserController', [
        'only' => ['index', 'store', 'destroy']
    ]);
});

/**
 * Mail
 */
Route::group(['prefix' => 'mail'], function() {
    Route::apiResource('domains', 'MailDomainController', [
        'only' => ['index', 'show', 'store', 'destroy']
    ]);
    Route::apiResource('users', 'MailUserController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);
    Route::apiResource('aliases', 'MailAliasController', [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);
});
