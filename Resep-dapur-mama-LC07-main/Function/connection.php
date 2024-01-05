<?php

    $config = array(
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'resep_dapur_mama',
    );

    // $config = array(
    //     'server' => getenv('DB_SERVER') ?: 'localhost',
    //     'username' => getenv('DB_USERNAME') ?: 'your_username',
    //     'password' => getenv('DB_PASSWORD') ?: 'your_password',
    //     'database' => getenv('DB_DATABASE') ?: 'resep_dapur_mama',
    // );
    

    $conn = new mysqli($config['server'], $config['username'], $config['password'], $config['database']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>