<?php
/**
 * Created by PhpStorm.
 * User: Sergo
 * Date: 08.05.2016
 * Time: 16:36
 */

return [
    'auth' => [
        'authorize' => 'Controller',
        'authenticate' => [
            'Form' => [
                'userModel' => 'Users',
                'fields' => [
                    'username' => 'login',
                    'password' => 'password'
                ]
            ]
        ],
        'loginAction' => [
            'controller' => 'Users',
            'action' => 'login'
        ],
        'loginRedirect' => [
            'controller' => 'Bids',
            'action' => 'recent'
        ],
        'logoutRedirect' => [
            'controller' => 'Users',
            'action' => 'login',
        ],
    ]
];