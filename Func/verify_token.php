<?php

// function returns true if user has right token and is logged in
if(!function_exists('verify_token')){

    function verify_token(){
        include '/home/a/www/Lib/var.php';
        include '/home/a/www/Lib/mysql.php';
        include '/home/a/www/Func/get_ip_address.php';
    
        if(isset($_COOKIE[$cookie_token_name])){
    
            $token = $_COOKIE[$cookie_token_name]; // generate token for user cookie
            $ip = getIPAddress(); // get users ip address
            
            // getting hashes from given generated token, and ip
            $token_hash = hash($hash_algo, $token);
            $ip_hash    = hash($hash_algo, $ip);
    
            // combining two hashes and hashing it to generate database token
            $db_token = $token_hash . $ip_hash;
            $db_token_hash = hash($hash_algo, $db_token);
    
            // compare to the token thats stored in the database
            $sql = new MysqliDb($host, $user, $pass, $db);
            $sql->where($token_column, $db_token_hash);
    
            // count how many of these kind of tokens exist, and if theres 1 token
            // that means user is currently logged in
            if($sql->getValue($user_table_name, 'COUNT(*)') >= 1){
                return true;
            }
    
        }
        return false;
    }
}

?>
