<?php

return array(

    'site_config' => array(
        'site_name'   => 'Cpanel',
        'title'       => 'My Admin Panel',
        'description' => 'Laravel 4 Admin Panel'
    ),

    //menu 2 type are available single or dropdown and it must be a route
    'menu' => array(
        'Dashboard' => array('type' => 'single', 'route' => 'admin.home'),
        'Users'     => array('type' => 'dropdown', 'links' => array(
            'Manage Users' => array('route' => 'admin.users.index'),
            'Groups'       => array('route' => 'admin.groups.index'),
            'Permissions'  => array('route' => 'admin.permissions.index')
        )),
    ),

    'views' => array(

        'layout' => 'cpanel::layouts',

        'dashboard' => 'cpanel::dashboard.index',
        'login'     => 'cpanel::dashboard.login',
        'register'  => 'cpanel::dashboard.register',

        // Users views
        'users_index'      => 'cpanel::users.index',
        'users_show'       => 'cpanel::users.show',
        'users_edit'       => 'cpanel::users.edit',
        'users_create'     => 'cpanel::users.create',
        'users_permission' => 'cpanel::users.permission',

        //Groups Views
        'groups_index'      => 'cpanel::groups.index',
        'groups_create'     => 'cpanel::groups.create',
        'groups_edit'       => 'cpanel::groups.edit',
        'groups_permission' => 'cpanel::groups.permission',

        //Permissions Views
        'permissions_index'  => 'cpanel::permissions.index',
        'permissions_edit'   => 'cpanel::permissions.edit',
        'permissions_create' => 'cpanel::permissions.create',

        //Throttling Views
        'throttle_status' => 'cpanel::throttle.index',
    ),

    'validation' => array(
        'user'       => 'Stevemo\Cpanel\Services\Validators\Users\Validator',
        'permission' => 'Stevemo\Cpanel\Services\Validators\Permissions\Validator',
    ),
);
