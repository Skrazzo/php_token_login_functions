<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}




// function will generate token for database
// and set token for user, in user cookies
function generate_token($username){
    // create a connection with a database
    include './Lib/mysql.php';
    include './Lib/var.php';
    include './Func/get_ip_address.php';

    $sql = new MysqliDb($host, $user, $pass, $db);

    $token = generateRandomString(32); // generate token for user cookie
    $ip = getIPAddress(); // get users ip address
    
    // getting hashes from given generated token, and ip
    $token_hash = hash('sha256', $token);
    $ip_hash    = hash('sha256', $ip);

    // combining two hashes and hashing it to generate database token
    $db_token = $token_hash . $ip_hash;
    $db_token_hash = hash('sha256', $db_token);

    // token will expire in 30 days
    setcookie($cookie_token_name, $token, time()+3600 * 24 * $token_expire_days);

    // upload token to a user database
    $sql->where($username_column, $username);
    $sql->update($user_table_name, array($token_column => $db_token_hash));
    
}

?>