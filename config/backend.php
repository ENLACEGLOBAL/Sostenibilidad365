<?php
    //retorna los parámetros de la segunda base de datos que será la que nos manejará el backend del aplicativo
    return [
        'host' => env('DB_HOST_BS', ''),
        'port' => env('DB_PORT_BS', ''),
        'schema' => env('DB_DATABASE_BS', ''),
        'user' => env('DB_USERNAME_BS', ''),
        'pass' => env('DB_PASSWORD_BS', '')
    ];
?>