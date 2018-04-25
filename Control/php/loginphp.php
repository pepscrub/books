<?php
    session_start();
    require "../../model/php/db_and_sensitive.php";
    $password_sanitised = !empty($_POST['password'])? test_user_input(($_POST['password'])) : null; //Sanitizing the password
    $decrypted_pass = password_decryption($_POST);

    $_SESSION['user'] = '0';



    if(password_verify($password_sanitised, $decrypted_pass[0]['password'])){
        $_SESSION['user_login'] = 'true';
        $curr_user = user_information($_POST);
        session_cache_limiter('private'); //Sets the cahce to private with a max age of the cache expire 

        $_SESSION['user_name'] = $curr_user[0]['username']; //[0] is the top 'Array' and ['fname'] grabs the respected column name
        $_SESSION['perm_type'] = $curr_user[0]['perm_type'];
        $_SESSION['Error'] = 'false';
        header("location: ../../");
    }else{
        $_SESSION['user_login'] = 'false';
        $_SESSION['Error'] = "Incorrect Password";
        header("location: ../../");
    }

?>
