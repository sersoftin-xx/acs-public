<?php
/**
 * Created by PhpStorm.
 * User: Sergo
 * Date: 08.05.2016
 * Time: 16:43
 */

return [
    'permissions' => [
        'Bids' => [
            'active',
            'recent',
            'getInfo',
            'block',
            'accept',
            'reject',
            'save',
            'edit'
        ],
        'Pcs' => [
            'block',
            'getInfo',
            'index',
            'save',
            'edit',
            'delete'
        ],
        'Clients' => [
            'block',
            'getInfo',
            'index',
            'save',
            'add',
            'edit',
            'delete'
        ],
        'Products' => [
            'getInfo',
            'index',
            'save',
            'add',
            'edit',
            'delete'
        ],
        'Users' => [
            'index',
            'login',
            'logout',
            'add',
            'save',
            'resetPassword',
            'delete',
            'getInfo'
        ],
        'Groups' => [
            'index',
            'getInfo',
            'add',
            'save',
            'delete'
        ],
        'Logs' => [
            'index',
            'clear'
        ]
    ]
];