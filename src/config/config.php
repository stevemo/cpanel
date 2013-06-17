<?php

return array(

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

        //Groups View
        'groups_index'      => 'cpanel::groups.index',
        'groups_create'     => 'cpanel::groups.create',
        'groups_edit'       => 'cpanel::groups.edit',
        'groups_permission' => 'cpanel::groups.permission',
    ),

    'validation' => array(
        'user'       => 'Stevemo\Cpanel\Services\Validators\Users\Validator',
        'permission' => 'Stevemo\Cpanel\Services\Validators\Permissions\Validator',
    ),
);
