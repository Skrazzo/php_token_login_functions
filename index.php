<?php

include './Func/generate_token.php';
include './Func/register.php';
include './Func/verify_token.php';


if(verify_token()){
    echo 'true';
}else{
    echo 'false';
}
//generate_token();

?>