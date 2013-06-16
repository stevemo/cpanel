<?php

Route::group(array('prefix' => 'admin', 'before' => 'auth.cpanel'), function()
{
    Route::get('/', 'Stevemo\Cpanel\Controllers\CpanelController@index');
    Route::resource('users', 'Stevemo\Cpanel\Controllers\UsersController');
    Route::resource('groups', 'Stevemo\Cpanel\Controllers\GroupsController');
});


Route::get('admin/login', array(
    'as'   => 'admin.login',
    'uses' => 'Stevemo\Cpanel\Controllers\CpanelController@getLogin'
));

Route::post('admin/login','Stevemo\Cpanel\Controllers\CpanelController@postLogin');

Route::get('admin/logout', array(
    'as'   => 'admin.logout',
    'uses' => 'Stevemo\Cpanel\Controllers\CpanelController@getLogout'
));

Route::get('admin/register', array(
    'as'   => 'admin.register',
    'uses' => 'Stevemo\Cpanel\Controllers\CpanelController@getRegister'
));

Route::post('admin/register','Stevemo\Cpanel\Controllers\CpanelController@postRegister');


/**
 * Filter for the admin site
 */
Route::filter('auth.cpanel', function($route, $request, $rules = null)
{
    if (! Sentry::check())
    {
        Session::put('url.intended', URL::full());
        return Redirect::route('admin.login');
    } 
});