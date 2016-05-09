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
            'caption' => 'Active',
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
            'caption' => 'Bids',
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
            'name' => 'clients',
            'caption' => 'Clients',
            'hasBadge' => true,
            'icon' => 'glyphicon glyphicon-user',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Clients',
            'action' => 'index',
            'finder' => 'all'
        ],
        [
            'name' => 'pcs',
            'caption' => 'PCs',
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
            'name' => 'products',
            'caption' => 'Products',
            'hasBadge' => true,
            'icon' => 'fa fa-cubes',
            'classes' => [
                'badge' => null,
                'li' => 'hidden-xs hidden-sm hidden-md'
            ],
            'controller' => 'Products',
            'action' => 'index',
            'finder' => 'all'
        ]
    ],
    'administrators' => [
        [
            'name' => 'users',
            'caption' => 'Users',
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
            'name' => 'products',
            'caption' => 'Products',
            'hasBadge' => true,
            'icon' => 'fa fa-cubes',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Products',
            'action' => 'index',
            'finder' => 'all'
        ]
    ]
];