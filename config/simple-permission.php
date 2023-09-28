<?php

return [
    'middleware' => [
        'web', 'auth', 'auth-gates'
    ],

    'views' => [
        'layouts'        => [
            'app'   => 'simple-permission::layouts.app',
        ],
        'roles'         => [
            'index'     => 'simple-permission::roles.index',
            'create'    => 'simple-permission::roles.create',
            'edit'      => 'simple-permission::roles.edit',
            'show'      => 'simple-permission::roles.show',
        ],
        'permission'    => [
            'index'     => 'simple-permission::permissions.index',
            'create'    => 'simple-permission::permissions.create',
            'edit'      => 'simple-permission::permissions.edit',
            'show'      => 'simple-permission::permissions.show',
        ],
    ],
];
