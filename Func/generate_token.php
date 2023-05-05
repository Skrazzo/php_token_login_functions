<?php


if(!function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}




// function will generate token for database
// and set token for user, in user cookies
if(!function_exists('generate_token')){
    function generate_token($username){
        // create a connection with a database
        include './Lib/mysql.php';
        include './Lib/var.php';
        include './Func/get_ip_address.php';
    
        $sql = new MysqliDb($host, $user, $pass, $db);
    
        $token = generateRandomString(32); // generate token for user cookie
        $ip = getIPAddress(); // get users ip address
        
        // generate database side token
        $db_token_hash = return_db_token($token, $ip);
    
        // token will expire in 30 days
        setcookie($cookie_token_name, $token, time()+3600 * 24 * $token_expire_days);
    
        // upload token to a user database
        $sql->where($username_column, $username);
        $sql->update($user_table_name, array($token_column => $db_token_hash));
        
    }
}



// this function creates token for the database to store
// and returns string that should be used to store as token on database
if(!function_exists('return_db_token')){
    function return_db_token($cookie_token, $ip){
        include './Lib/var.php';

        // getting hashes from given generated token, and ip
        $token_hash = hash($hash_algo, $cookie_token);
        $ip_hash    = hash($hash_algo, $ip);
    
        // combining two hashes and hashing it to generate database token
        $db_token = $token_hash . $ip_hash;
        return hash($hash_algo, $db_token);
    }
}
?>