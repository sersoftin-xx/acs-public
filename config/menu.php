<?php
/**
 * Created by PhpStorm.
 * User: Sergo
 * Date: 08.12.2015
 * Time: 23:17
 */

return [
    'users' => [
        [
            'name' => 'active_bids',
            'caption' => 'Активные',
            'hasBadge' => true,
            'icon' => 'fa fa-check-square-o',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Bids',
            'action' => 'active',
            'finder' => 'active'
        ],
        [
            'name' => 'new_bids',
            'caption' => 'Новые',
            'hasBadge' => true,
            'icon' => 'glyphicon glyphicon-asterisk',
            'classes' => [
                'badge' => 'red-badge',
                'li' => null
            ],
            'controller' => 'Bids',
            'action' => 'recent',
            'finder' => 'recent'
        ],
        [
            'name' => 'pcs',
            'caption' => 'Компьютеры',
            'hasBadge' => true,
            'icon' => 'fa fa-laptop',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Pcs',
            'action' => 'index',
            'finder' => 'all'
        ],
        [
            'name' => 'clients',
            'caption' => 'Клиенты',
            'hasBadge' => true,
            'icon' => 'glyphicon glyphicon-user',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Clients',
            'action' => 'index',
            'finder' => 'all'
        ]
    ],
    'administrators' => [
        [
            'name' => 'users',
            'caption' => 'Пользователи',
            'hasBadge' => true,
            'icon' => 'fa fa-user',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Users',
            'action' => 'index',
            'finder' => 'all'
        ],
        [
            'name' => 'groups',
            'caption' => 'Группы',
            'hasBadge' => true,
            'icon' => 'fa fa-users',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Groups',
            'action' => 'index',
            'finder' => 'all'
        ],
        [
            'name' => 'products',
            'caption' => 'Продукты',
            'hasBadge' => true,
            'icon' => 'fa fa-cubes',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Products',
            'action' => 'index',
            'finder' => 'all'
        ],
        [
            'name' => 'logs',
            'caption' => 'Логи',
            'hasBadge' => true,
            'icon' => 'fa fa-history',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Logs',
            'action' => 'index',
            'finder' => 'all'
        ]
    ]
];