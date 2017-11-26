<?php

Route::get('/', 'RootController@redirect')->name('root');

// Authentication
Route::get('/login', 'AuthenticationController@showLoginForm')->name('login');
Route::post('/login', 'AuthenticationController@login');
Route::post('/logout', 'AuthenticationController@logout')->name('logout');

// Dashboard
Route::get('/dashboard', 'DashboardController@showDashboard')->name('dashboard');

// DNS
Route::get('/dns/zones', 'DnsZoneController@index')->name('dns_zones');
