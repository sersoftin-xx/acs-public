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
            'save'
        ],
        'Pcs' => [
            'block',
            'getInfo',
            'index',
            'save',
            'delete'
        ],
        'Clients' => [
            'block',
            'getInfo',
            'index',
            'add',
            'save',
            'delete'
        ],
        'Products' => [
            'getInfo',
            'download',
            'index',
            'add',
            'save',
            'update',
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
            'save'
        ],
        'Logs' => [
            'index',
            'clear'
        ]
    ]
];