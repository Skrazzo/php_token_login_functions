<?php


function isPasswordStrong($password) {
    // Password must be at least 8 characters long
    if (strlen($password) < 8) {
      return false;
    }
  
    // Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character
    if (!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[^a-zA-Z0-9]/", $password)) {
      return false;
    }
  
    return true;
}

// function returns true, if user already exists
function user_exists($username){
    include './Lib/var.php';
    include './Lib/mysql.php';

    $sql = new MysqliDb($host, $user, $pass, $db);
    $sql->where($username_column, $username);
    
    // count and verify usernames, and return true if already exists one
    if($sql->getValue($user_table_name ,'COUNT(*)') >= 1){
        return true;
    }
    return false;

}

// function that registers user
// before that it checks if the user exists in the database
// and if password is strong
// return true if user has registered and false if user wasn't
// auto login will provide with token generation, which will set user token in a cookie
// and should automatically login user into website
function register_user($username, $password, $strong_check = false, $auto_login = false){
    include './Lib/var.php';
    include './Lib/mysql.php';

    if($strong_check){
        // check if password is strong
        if(!isPasswordStrong($password)){
            return false;
        }
    }

    // if user doesn't exist you may continue with user registration
    if(!user_exists($username)){
        $sql = new MysqliDb($host, $user, $pass, $db);

        $data = array(
            $username_column    => $username,
            $password_column    => password_hash($password, PASSWORD_BCRYPT),
            $token_column       => null
        );
        
        // insert user into the database and 
        $sql->insert($user_table_name, $data);

        // if auto login is requested then create token
        if($auto_login) generate_token($username);

        return true;
    }

    return false;

}

?>