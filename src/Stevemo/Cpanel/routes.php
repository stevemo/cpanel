<?php

Route::get('admin', 'Stevemo\Cpanel\Controllers\CpanelController@index');

Route::group(array('prefix' => 'admin'), function()
{
    Route::resource('users', 'Stevemo\Cpanel\Controllers\UsersController');
});