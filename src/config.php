<?php return [

    'db' => [
        'host'   => '127.0.01',
        'port'   => '3306',
        'dbname' => 'mvc',
        'user'   => 'homestead',
        'password' => 'secret',
    ],

    'mailing' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'username' => 'rkhilenksmtp@gmail.com',
        'password' => 'asdQWE123',
        'encryption' => 'tls',
        'sender' => ['john@doe.com' => 'John Doe'],
    ]

];?>