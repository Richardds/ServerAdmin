<?php

Route::get('/', 'RootController@redirect')->name('root');

// Authentication
Route::get('login', 'AuthenticationController@showLoginForm')->name('login');
Route::post('login', 'AuthenticationController@login');
Route::post('logout', 'AuthenticationController@logout')->name('logout');

// Dashboard
Route::get('dashboard', 'DashboardController@showDashboard')->name('dashboard');

// Database
Route::group(['prefix' => 'database'], function() {
    Route::get('schemas', 'DatabaseSchemaController@databases')->name('database_schemas');
    Route::get('users', 'DatabaseUserController@users')->name('database_users');
});

// DNS
Route::group(['prefix' => 'dns'], function() {
    Route::get('zones', 'DnsZoneController@zones')->name('dns_zones');
    Route::get('zones/{zone}', 'DnsZoneController@zone')->name('dns_records');
});

// Cron
Route::group(['prefix' => 'cron'], function() {
    Route::get('tasks', 'CronController@cron_tasks')->name('cron_tasks');
});

// Mail
Route::group(['prefix' => 'mail'], function() {
    Route::get('domains', 'MailDomainController@domains')->name('mail_domains');
    Route::get('domains/{domain}', 'MailUserController@users')->name('mail_users');
});

// Firewall
Route::group(['prefix' => 'firewall'], function() {
    Route::get('rules', 'FirewallRuleController@rules')->name('firewall_rules');
});
