<?php

Route::group(array('prefix' => 'admin', 'before' => 'auth.cpanel'), function()
{
    Route::get('/', 'Stevemo\Cpanel\Controllers\CpanelController@index');
    Route::resource('users', 'Stevemo\Cpanel\Controllers\UsersController');
    Route::resource('groups', 'Stevemo\Cpanel\Controllers\GroupsController',array('except' => array('show')));
    Route::resource('permissions', 'Stevemo\Cpanel\Controllers\PermissionsController',array('except' => array('show')));
});


Route::get('admin/groups/{groups}/permissions', array(
    'as' => 'admin.groups.permissions',
    'uses' => 'Stevemo\Cpanel\Controllers\GroupsPermissionsController@index'
));

Route::put('admin/groups/{groups}/permissions', array(
    'uses' => 'Stevemo\Cpanel\Controllers\GroupsPermissionsController@update'
));



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