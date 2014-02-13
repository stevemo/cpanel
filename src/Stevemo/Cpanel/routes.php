<?php

Route::group(array('prefix' => Config::get('cpanel::prefix', 'admin')), function()
{
    /*
    |--------------------------------------------------------------------------
    | Cpanel Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('/', array(
        'as'     => 'cpanel.home',
        'uses'   => 'Stevemo\Cpanel\Controllers\CpanelController@index',
        'before' => 'auth.cpanel:cpanel.view'
    ));

    /*
    |--------------------------------------------------------------------------
    | Cpanel Permissions Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('permissions', array(
        'as'     => 'cpanel.permissions.index',
        'uses'   => 'Stevemo\Cpanel\Controllers\PermissionsController@index',
        'before' => 'auth.cpanel'
    ));
    Route::post('permissions', array(
        'as'     => 'cpanel.permissions.store',
        'uses'   => 'Stevemo\Cpanel\Controllers\PermissionsController@store',
        'before' => 'auth.cpanel'
    ));
    Route::get('permissions/create', array(
        'as'     => 'cpanel.permissions.create',
        'uses'   => 'Stevemo\Cpanel\Controllers\PermissionsController@create',
        'before' => 'auth.cpanel'
    ));
    Route::get('permissions/{id}/edit', array(
        'as'     => 'cpanel.permissions.edit',
        'uses'   => 'Stevemo\Cpanel\Controllers\PermissionsController@edit',
        'before' => 'auth.cpanel'
    ));
    Route::put('permissions/{id}', array(
        'as'     => 'cpanel.permissions.update',
        'uses'   => 'Stevemo\Cpanel\Controllers\PermissionsController@update',
        'before' => 'auth.cpanel'
    ));
    Route::delete('permissions/{id}', array(
        'as'     => 'cpanel.permissions.destroy',
        'uses'   => 'Stevemo\Cpanel\Controllers\PermissionsController@destroy',
        'before' => 'auth.cpanel'
    ));

    /*
    |--------------------------------------------------------------------------
    | Cpanel Groups Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('groups', array(
        'as'     => 'cpanel.groups.index',
        'uses'   => 'Stevemo\Cpanel\Controllers\GroupsController@index',
        'before' => 'auth.cpanel'
    ));
    Route::post('groups', array(
        'as'     => 'cpanel.groups.store',
        'uses'   => 'Stevemo\Cpanel\Controllers\GroupsController@store',
        'before' => 'auth.cpanel'
    ));
    Route::get('groups/create', array(
        'as'     => 'cpanel.groups.create',
        'uses'   => 'Stevemo\Cpanel\Controllers\GroupsController@create',
        'before' => 'auth.cpanel'
    ));
    Route::get('groups/{id}/edit', array(
        'as'     => 'cpanel.groups.edit',
        'uses'   => 'Stevemo\Cpanel\Controllers\GroupsController@edit',
        'before' => 'auth.cpanel'
    ));
    Route::put('groups/{id}', array(
        'as'     => 'cpanel.groups.update',
        'uses'   => 'Stevemo\Cpanel\Controllers\GroupsController@update',
        'before' => 'auth.cpanel'
    ));
    Route::delete('groups/{id}', array(
        'as'     => 'cpanel.groups.destroy',
        'uses'   => 'Stevemo\Cpanel\Controllers\GroupsController@destroy',
        'before' => 'auth.cpanel'
    ));

    /*
    |--------------------------------------------------------------------------
    | Cpanel Users Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('users', array(
        'as'     => 'cpanel.users.index',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@index',
        'before' => 'auth.cpanel'
    ));
    Route::post('users', array(
        'as'     => 'cpanel.users.store',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@store',
        'before' => 'auth.cpanel'
    ));
    Route::get('users/create', array(
        'as'     => 'cpanel.users.create',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@create',
        'before' => 'auth.cpanel'
    ));
    Route::get('users/{id}', array(
        'as'     => 'cpanel.users.show',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@show',
        'before' => 'auth.cpanel'
    ));
    Route::get('users/{id}/edit', array(
        'as'     => 'cpanel.users.edit',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@edit',
        'before' => 'auth.cpanel'
    ));
    Route::put('users/{id}', array(
        'as'     => 'cpanel.users.update',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@update',
        'before' => 'auth.cpanel'
    ));
    Route::delete('users/{id}', array(
        'as'     => 'cpanel.users.destroy',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@destroy',
        'before' => 'auth.cpanel'
    ));
    Route::put('users/{users}/activate', array(
        'as'     => 'cpanel.users.activate',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@putActivate',
        'before' => 'auth.cpanel:users.update'
    ));

    Route::put('users/{users}/deactivate', array(
        'as'     => 'cpanel.users.deactivate',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersController@putDeactivate',
        'before' => 'auth.cpanel:users.update'
    ));


    /*
    |--------------------------------------------------------------------------
    | Cpanel Users Permissions Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('users/{users}/permissions', array(
        'as'     => 'cpanel.users.permissions',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersPermissionsController@index',
        'before' => 'auth.cpanel:users.update'
    ));

    Route::put('users/{users}/permissions', array(
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersPermissionsController@update',
        'before' => 'auth.cpanel:users.update'
    ));

    /*
    |--------------------------------------------------------------------------
    | Cpanel Users Throttling Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('users/{user}/throttling', array(
        'as'     => 'cpanel.users.throttling',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersThrottlingController@getStatus',
        'before' => 'auth.cpanel:users.view'
    ));

    Route::put('users/{user}/throttling/{action}', array(
        'as'     => 'cpanel.users.throttling.update',
        'uses'   => 'Stevemo\Cpanel\Controllers\UsersThrottlingController@putStatus',
        'before' => 'auth.cpanel:users.update'
    ));

    /*
    |--------------------------------------------------------------------------
    | Cpanel Login/Logout/Register Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('login', array(
        'as'   => 'cpanel.login',
        'uses' => 'Stevemo\Cpanel\Controllers\CpanelController@getLogin'
    ));

    Route::get('logout', array(
        'as'   => 'cpanel.logout',
        'uses' => 'Stevemo\Cpanel\Controllers\CpanelController@getLogout'
    ));

    Route::post('login','Stevemo\Cpanel\Controllers\CpanelController@postLogin');

    Route::get('register', array(
        'as'   => 'cpanel.register',
        'uses' => 'Stevemo\Cpanel\Controllers\CpanelController@getRegister'
    ));

    Route::post('register','Stevemo\Cpanel\Controllers\CpanelController@postRegister');

    /*
    |--------------------------------------------------------------------------
    | Cpanel Password management Routes
    |--------------------------------------------------------------------------
    |
    |
    */
    Route::get('password/forgot', array(
        'as'   => 'cpanel.password.forgot',
        'uses' => 'Stevemo\Cpanel\Controllers\PasswordController@getForgot'
    ));

    Route::post('password/forgot','Stevemo\Cpanel\Controllers\PasswordController@postForgot');

    Route::get('password/reset/{code}', array(
        'as'   => 'cpanel.password.reset',
        'uses' => 'Stevemo\Cpanel\Controllers\PasswordController@getReset'
    ));

    Route::post('password/reset',array(
        'as' => 'cpanel.password.update',
        'uses' => 'Stevemo\Cpanel\Controllers\PasswordController@postReset'
    ));

});




/*
|--------------------------------------------------------------------------
| Admin auth filter
|--------------------------------------------------------------------------
| You need to give your routes a name before using this filter.
| I assume you are using resource. so the route for the UsersController index method
| will be admin.users.index then the filter will look for permission on users.view
| You can provide your own rule by passing a argument to the filter
|
*/
Route::filter('auth.cpanel', function($route, $request, $userRule = null)
{
    if (! Sentry::check())
    {
        Session::put('url.intended', URL::full());
        return Redirect::route('cpanel.login');
    }

    // no special route name passed, use the current name route
    if ( is_null($userRule) )
    {
        list($prefix, $module, $rule) = explode('.', Route::currentRouteName());
        switch ($rule)
        {
            case 'index':
            case 'show':
                $userRule = $module.'.view';
                break;
            case 'create':
            case 'store':
                $userRule = $module.'.create';
                break;
            case 'edit':
            case 'update':
                $userRule = $module.'.update';
                break;
            case 'destroy':
                $userRule = $module.'.delete';
                break;
            default:
                $userRule = Route::currentRouteName();
                break;
        }
    }
    // no access to the request page and request page not the root admin page
    if ( ! Sentry::hasAccess($userRule) and $userRule !== 'cpanel.view' )
    {
        return Redirect::route('cpanel.home')
            ->with('error', Lang::get('cpanel::permissions.access_denied'));
    }
    // no access to the request page and request page is the root admin page
    else if( ! Sentry::hasAccess($userRule) and $userRule === 'cpanel.view' )
    {
        //can't see the admin home page go back to home site page
        return Redirect::to('/')
            ->with('error', Lang::get('cpanel::permissions.access_denied'));
    }

});
