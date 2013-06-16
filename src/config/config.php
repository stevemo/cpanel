<?php

return array(

    'views' => array(

        'dashboard' => 'cpanel::dashboard.index',
        'login'     => 'cpanel::dashboard.login',
        'register'  => 'cpanel::dashboard.register',

        // User views
        'users_show'   => 'cpanel::users.show',
        'users_create' => 'cpanel::users.create',
        'users_edit'   => 'cpanel::users.edit',
    ),

    'validation' => array(
        'user'       => 'Stevemo\Cpanel\Services\Validators\Users\Validator',
        'permission' => 'Stevemo\Cpanel\Services\Validators\Permissions\Validator',
    ),
);