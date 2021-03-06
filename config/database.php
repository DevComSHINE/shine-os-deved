<?php return array (
  'fetch' => 8,
  'default' => 'mysql',
  'connections' =>
  array (
    'sqlite' =>
    array (
      'driver' => 'sqlite',
      'database' => 'C:\\xampp\\htdocs\\shineoslaravel2\\storage\\database.sqlite',
      'prefix' => '',
    ),
    'mysql' =>
    array (
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'shinedb',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
      'strict' => false,
    ),
    'pgsql' =>
    array (
      'driver' => 'pgsql',
      'host' => 'localhost',
      'database' => 'shinedb',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'prefix' => '',
      'schema' => 'public',
    ),
    'sqlsrv' =>
    array (
      'driver' => 'sqlsrv',
      'host' => 'localhost',
      'database' => 'shinedb',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'prefix' => '',
    ),
  ),
  'migrations' => 'migrations',
  'redis' =>
  array (
    'cluster' => false,
    'default' =>
    array (
      'host' => '127.0.0.1',
      'port' => 6379,
      'database' => 0,
    ),
  ),
);
