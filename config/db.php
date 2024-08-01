<?php
return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=test;port=3308',
//    'username' => 'root',
//    'password' => '',
//    'charset' => 'utf8',
      'class' => 'yii\db\Connection',
      'dsn' => 'mysql:host='. env('DB_HOST') .';dbname='. env('DB_NAME'). ';port='. env('DB_PORT'),
      'username' => env('DB_USER'),
      'password' => env('DB_PASS'),
      'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

