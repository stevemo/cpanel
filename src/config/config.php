<?php

return array(

    'views' => array(

        'layout' => 'cpanel::layouts',

        'dashboard' => 'cpanel::dashboard.index',
        'login'     => 'cpanel::dashboard.login',
        'register'  => 'cpanel::dashboard.register',

        // User views
        'users_index'      => 'cpanel::users.index',
        'users_show'       => 'cpanel::users.show',
        'users_edit'       => 'cpanel::users.edit',
        'users_create'     => 'cpanel::users.create',
        'users_permission' => 'cpanel::users.permission',
    ),

    'validation' => array(
        'user'       => 'Stevemo\Cpanel\Services\Validators\Users\Validator',
        'permission' => 'Stevemo\Cpanel\Services\Validators\Permissions\Validator',
    ),
);
