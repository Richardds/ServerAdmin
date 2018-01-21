<?php

Route::get('/', 'RootController@redirect')->name('root');

// Authentication
Route::get('login', 'AuthenticationController@showLoginForm')->name('login');
Route::post('login', 'AuthenticationController@login');
Route::post('logout', 'AuthenticationController@logout')->name('logout');

// Dashboard
Route::get('dashboard', 'DashboardController@showDashboard')->name('dashboard');

// DNS
Route::group(['prefix' => 'dns'], function() {
    Route::get('zones', 'DnsZoneController@zones')->name('dns_zones');
    Route::get('zones/{zone}', 'DnsZoneController@zone')->name('dns_records');
});

// Cron
Route::get('cron', 'CronController@cron_tasks')->name('cron');
