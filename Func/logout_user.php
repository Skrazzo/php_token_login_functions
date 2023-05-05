<?php

// function deletes db_token from database so the user isn't logged in
// automatically and is asked to log in
if(!function_exists('logout')){
    function logout(){
        include './Lib/var.php';
        include './Lib/mysql.php';
        include './Func/get_ip_address.php';
        include './Func/generate_token.php';

        // generate database token
        $db_token = return_db_token($_COOKIE[$cookie_token_name], getIPAddress());
        
        // make an sql statement, where it will set token to null with matching database token
        $sql = new MysqliDb($host, $user, $pass, $db);
        $sql->where($token_column, $db_token);
        $sql->update($user_table_name, array($token_column => null));

    
    }
}

?>