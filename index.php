<?php

include './Func/generate_token.php';
include './Func/register_user.php';
include './Func/verify_token.php';
include './Func/login_user.php';
include './Func/logout_user.php';



// strong1@A
if(verify_token()){
    echo 'true';
    
}else{
    echo 'false';
}

?>