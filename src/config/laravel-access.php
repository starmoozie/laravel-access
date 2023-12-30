<?php

return [
    'auth_route' => [
        'login', // login route
        'register' // register route
    ],
    'route_prefix'  => '', // ex api, api/v1
    'segment' => 1, // if url path is only ex: "http://localhost/permissions" then 1, if "http://localhost/api/permissions" then 2 etc...
    'register' => env('LARAVEL_ACCESS_REGISTER', false), // if register is false, then cannot register new user
    'setup_auth_route' => true, // if you want to using your route controller, setup to false
    'database' => [
        'data' => [ // default database seeder
            'menus' => [
                ['name' => 'permission'],
                ['name' => 'menu'],
                ['name' => 'role'],
                ['name' => 'user'],
            ],
            'permissions' => [
                [
                    'name'   => 'Read',
                    'key'    => 'index',
                    'method' => 'get'
                ],
                [
                    'name'   => 'Create',
                    'key'    => 'store',
                    'method' => 'post'
                ],
                [
                    'name'   => 'Show',
                    'key'    => 'show',
                    'method' => 'get'
                ],
                [
                    'name'   => 'Update',
                    'key'    => 'update',
                    'method' => 'put'
                ],
                [
                    'name'   => 'Delete',
                    'key'    => 'delete',
                    'method' => 'delete'
                ]
            ],
            'roles' => [
                ['name' => 'developer'],
                ['name' => 'admin']
            ],
            'users' => [
                [
                    'name'       => 'starmoozie',
                    'email'      => 'starmoozie@gmail.com',
                    'password'   => 'password'
                ]
            ]
        ],
        'columns' => [ // columns length
            'users' => [
                'name'  => 50,
                'email' => 50
            ],
            'roles' => [
                'name' => 20
            ],
            'permissions' => [
                'name' => 10,
                'key'  => 10,
                'method' => 6
            ],
            'menus' => [
                'name'       => 15,
                'endpoint'   => 15,
                'controller' => 20
            ],
        ]
    ],
    'guards' => [ // add passport guards
        'api' => [
            'driver' => 'passport',
            'provider' => 'users'
        ]
    ]
];
