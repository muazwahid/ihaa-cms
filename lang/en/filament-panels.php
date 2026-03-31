<?php

return [
    'pages' => [
        'dashboard' => [
            'title' => 'Dashbaord',
            'navigation_label' => 'Dashbaord',
        ],

        'auth' => [
            'login' => [
                'title' => 'Log in',
                'heading' => 'Sign in',

                'form' => [
                    'email' => [
                        'label' => 'Email Address',
                    ],
                    'password' => [
                        'label' => 'Password',
                    ],
                    'remember' => [
                        'label' => 'Remember me',
                    ],
                ],

                'actions' => [
                    'authenticate' => [
                        'label' => 'Sign in',
                    ],
                ],
            ],
        ],
    ],

    'resources' => [
        'actions' => [
            'create' => [
                'label' => 'New :label',
            ],
            'edit' => [
                'label' => 'Eidt',
            ],
            'view' => [
                'label' => 'View',
            ],
        ],
    ],
];