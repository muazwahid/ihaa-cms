<?php

return [
    'pages' => [
        'dashboard' => [
            'title' => 'ޑޭޝްބޯޑު',
            'navigation_label' => 'ޑޭޝްބޯޑު',
        ],

        'auth' => [
            'login' => [
                'title' => 'ލޮގިން',
                'heading' => 'ސައިން އިން',

                'form' => [
                    'email' => [
                        'label' => 'އީމެއިލް އެޑްރެސް',
                    ],
                    'password' => [
                        'label' => 'ޕާސްވޯޑް',
                    ],
                    'remember' => [
                        'label' => 'ހަނދާން ބަހައްޓަވާ',
                    ],
                ],

                'actions' => [
                    'authenticate' => [
                        'label' => 'ސައިން އިން',
                    ],
                ],
            ],
        ],
    ],

    'resources' => [
        'actions' => [
            'create' => [
                'label' => 'އާ :label',
            ],
            'edit' => [
                'label' => 'ބަދަލުކުރޭ',
            ],
            'view' => [
                'label' => 'ބަލާލުމަށް',
            ],
        ],
    ],
];