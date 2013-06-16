<?php

Route::get('admin', 'Stevemo\Cpanel\Controllers\CpanelController@index');

Route::group(array('prefix' => 'admin', 'before' => 'auth.cpanel'), function()
{
    Route::resource('users', 'Stevemo\Cpanel\Controllers\UsersController');
});

Route::filter('auth.cpanel', function($route, $request, $rules = null)
{
    Sentry::check();
});