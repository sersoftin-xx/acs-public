<?php
/**
 * Created by PhpStorm.
 * User: Sergo
 * Date: 08.12.2015
 * Time: 23:17
 */

return [
    'menu' => [
        [
            'name' => 'active_bids',
            'caption' => 'Active',
            'icon' => 'fa fa-check-square-o',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Bids',
            'action' => 'index'
        ],
        [
            'name' => 'new_bids',
            'caption' => 'Bids',
            'icon' => 'glyphicon glyphicon-asterisk',
            'classes' => [
                'badge' => 'red-badge',
                'li' => null
            ],
            'controller' => 'Bids',
            'action' => 'recent'
        ],
        [
            'name' => 'users',
            'caption' => 'Users',
            'icon' => 'glyphicon glyphicon-user',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Users',
            'action' => 'index'
        ],
        [
            'name' => 'pcs',
            'caption' => 'PCs',
            'icon' => 'fa fa-laptop',
            'classes' => [
                'badge' => null,
                'li' => null
            ],
            'controller' => 'Pcs',
            'action' => 'index'
        ],
        [
            'name' => 'products',
            'caption' => 'Products',
            'icon' => 'fa fa-cubes',
            'classes' => [
                'badge' => null,
                'li' => 'hidden-xs hidden-sm hidden-md'
            ],
            'controller' => 'Products',
            'action' => 'index'
        ]
    ]
];