<?php

// function that checks users password and username
// if everything is successfull, function will return true
// otherwise false
if(!function_exists('login')){
    function login($username, $password){
        include './Lib/var.php';
        include './Lib/mysql.php';

        $sql = new MysqliDb($host, $user, $pass, $db);
        
        // hash password before verifing it
        $password = hash($hash_algo, $password);

        // request hashed password from database
        $sql->where($username_column, $username);
        $hashed_pass = $sql->getValue($user_table_name, $password_column);

        // if user doesn't exist, sql will return empty string
        if(empty($hashed_pass)) return false;
        
        // check password and return true if it matches
        if(password_verify($password, $hashed_pass)) return true;
        return false;
    }
}

?>