# ![php](https://user-images.githubusercontent.com/58330666/236512957-6a25312e-4f0f-4ab4-b283-96f0fbd95a07.png) PHP login system functions
### Why to use?
* It will make me very happy :)
* securiti 🔐
* Tokens get generated from ip + random token taken from cookies. (That means that if someone would steal your token, person still wouldn't be able to log into your account because token simply wouldn't match with the database version)

# To start
* Copy paste repository
* Edit Lib/var.php file so that mysql class can connect to your database
* Configurate Lib/var.php file to match your database with user information
* Start using needed function with include './Lib/**[function_you_need]**.php

# Exmaples
Including files:
```php
include './Func/generate_token.php'; // generate database/client side tokens
include './Func/register_user.php'; // registering a user
include './Func/verify_token.php'; // proving if user is logged in
include './Func/login_user.php'; // login user with given password and username
include './Func/logout_user.php'; // logout from an account
```

Creating user account:
```php
// register a user
register_user('skrazzo', 'test');

// strong check users password (won't let to register with weak password)
register_user('skrazzo', 'test', true);

// auto login user after creating it's account
// that means after creating it, function will generate token and log user in
register_user('skrazzo', 'test', false, true);
```

User login:
```php
// login, function will return false on incorrect login
// and true on correct one
$username = 'skrazzo';
if(login($username, 'test')){
    // generates token for server side, and client side
    generate_token($username); 
}
```

Verify users login token:
```php
// if user has been logged in before, hes cookie token has to be saved in 
// token cookie, calling verify_token(); will return true on successfull token
// and will return false, if token is incorrect
if(!verify_token()){
    die('incorrect login!');
}

// proceed to the website
```
Logout:
```php
// by calling logout(); function, php function will remove database token
// so the user won't be able to log in anymore
logout();
```
### ![mysql](https://user-images.githubusercontent.com/58330666/236526883-6dcbc5ab-f383-4025-8b84-38c424e2afb0.png) Mysql library
* [PHP-MySQLi-Database-Class](https://github.com/ThingEngineer/PHP-MySQLi-Database-Class)


### Variables
You should edit Lib/var.php file, and create your own database.
Here's and example:
```php
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
```
Here's database example:
![database](https://user-images.githubusercontent.com/58330666/236520296-f41cc162-70f6-4de9-85e0-ce013b26c11e.png)
### Hashing algos
* [hash_algos();](https://www.php.net/manual/en/function.hash-algos.php)
