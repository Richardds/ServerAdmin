<?php

Route::get('/', 'RootController@redirect')->name('root');

// Authentication
Route::get('login', 'AuthenticationController@showLoginForm')->name('login');
Route::post('login', 'AuthenticationController@login');
Route::post('logout', 'AuthenticationController@logout')->name('logout');

// Dashboard
Route::get('dashboard', 'DashboardController@showDashboard')->name('dashboard');

// Sites
Route::get('sites', 'SiteController@sites')->name('sites');

// Database
Route::get('database', 'DatabaseSchemaController@databases')->name('database');
Route::get('database/users', 'DatabaseUserController@users')->name('database_users');

// DNS
Route::group(['prefix' => 'dns'], function() {
    Route::get('zones', 'DnsZoneController@zones')->name('dns_zones');
    Route::get('zones/{zone}', 'DnsZoneController@zone')->name('dns_records');
    Route::get('zones/{zone}/export', 'DnsZoneController@export')->name('dns_zone_export');
    Route::get('zones/{zone}/import', 'DnsZoneController@import')->name('dns_zone_import');
});

// Cron
Route::get('tasks', 'CronController@tasks')->name('tasks');

// Mail
Route::group(['prefix' => 'mail'], function() {
    Route::get('domains', 'MailDomainController@domains')->name('mail_domains');
    Route::get('domains/{domain}', 'MailUserController@users')->name('mail_users');
});

// Firewall
Route::get('firewall', 'FirewallRuleController@rules')->name('firewall');
