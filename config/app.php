<?php
/*
 * Server configuration
 */

return [
    'app' => [
        'debug' => true,
        'lang' => 'en'
    ],

    'database' => [
        'name' => 'framework',
        'username' => 'root',
        'password' => '',
        'db_type' => 'mysql',
        'connection' => '192.168.0.166',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
