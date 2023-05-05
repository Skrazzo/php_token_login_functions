<?php


// for db
$db     = 'users';        // database where table with users are stored
$host   = 'localhost';  // address for sql database
$user   = 'root';       // username for database login
$pass   = '';           // password for database login

// database table information
$user_table_name    = 'users';  // table name where users are stored
$password_column    = 'pass';   // column name with user passwords
$username_column    = 'user';   // column name with user usernames
$token_column       = 'token';  // column name with user database side tokens
$cookie_token_name  = 'token';  // cookie name where client side tokens will be stored

$token_expire_days  = 30;       // token cookie will expire after 30 days
$hash_algo          = 'sha256'; // selected hashing algorithm


?>
