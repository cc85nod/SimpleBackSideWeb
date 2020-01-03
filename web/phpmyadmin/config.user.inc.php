<?php
// config:
// https://docs.phpmyadmin.net/zh_CN/latest/config.html
$cfg['Servers'] = [
    1 => [
        // 'auth_type' => 'config',
        // 'user' => 'root',
        // 'password' => 'root',

        'auth_type' => 'cookie',
        // mysql in docker-compose.yml
        'host' => 'mysql',
        'port' => 3306,
    ]
];

?>