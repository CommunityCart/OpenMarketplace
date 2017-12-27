<?php

use App\Utility\Sidebar;

$menus = [
    'visitor' => [
        [
            'type'  => 'header',
            'header' => 'Welcome to Open Marketplace'
        ],
        [
            'type'  => 'link',
            'link'  => 'Click To Register',
            'icon'  => 'fa-pencil-square',
            'path'  => '/register'
        ],
        [
            'type'  => 'group',
            'group' => 'User Menu',
            'icon'  => 'fa-user',
            'css'   => 'active non-active',
            'menu'  => [
                'Login'          => [
                    'path' => '/login',
                    'icon' => 'fa-sign-in',
                ],
                'Reset Password' => [
                    'path' => '/reset',
                    'icon' => 'fa-compass',
                ]
            ]
        ]

    ],
    'user' => [

    ],
    'member' => [
        [
            'type'  => 'header',
            'header' => 'Welcome Member'
        ],
        [
            'type'  => 'link',
            'link'  => 'Dashboard',
            'icon'  => 'fa-dashboard',
            'path'  => '/dashboard'
        ]
    ],
    'admin' => [
        [
            'type'  => 'header',
            'header' => 'Welcome Admin'
        ],
        [
            'type'  => 'group',
            'group' => 'Admin Menu',
            'icon'  => 'fa-user',
            'css'   => 'active non-active',
            'menu' => [
                'Dashboard' => [
                    'path' => '/dashboard?collapse=false',
                    'icon' => 'fa-dashboard',
                    /*
                    'menu' => [
                        'Reporting' => [
                            'path' => '/dashboard/reporting',
                            'icon' => 'fa-dashboard',
                            'menu' => [
                                'Reporting 2' => [
                                    'path' => '/dashboard/reporting/2',
                                    'icon' => 'fa-dashboard'
                                ]
                            ]
                        ]
                    ]
                    */
                ],
                'Search Users' => [
                    'path'  => '/search/users',
                    'icon'  => 'fa-search'
                ],
                'View Users' => [
                    'path'  => '/admin/users',
                    'icon'  => 'fa-users'
                ]
            ]
        ],
        [
            'type'  => 'group',
            'group' => 'Support Menu',
            'icon'  => 'fa-support',
            'css'   => 'active non-active',
            'menu' => [
                'Help & FAQ' => [
                    'path' => '/help',
                    'icon' => 'fa-question-circle'
                ],
                'View Chats' => [
                    'path' => '/openchats',
                    'icon' => 'fa-wechat'
                ],
                'View Tickets'     => [
                    'path' => '/tickets',
                    'icon' => 'fa-folder-open'
                ]
            ]
        ]
    ],
    'site' => [
        [
            'type'  => 'header',
            'header' => 'Sitewide Links'
        ],
        [
            'type'  => 'link',
            'link' => 'Help & FAQ',
            'path' => '/help',
            'icon' => 'fa-question-circle'
        ],
        [
            'type'  => 'link',
            'link'  => 'Contact Us',
            'icon'  => 'fa-bullhorn',
            'path'  => '/contact'
        ]
    ]
];

Sidebar::setMenu($menus);