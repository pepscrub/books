<?php 
    //error_reporting(0);
    require "../../model/php/db_and_sensitive.php";

    session_start();
    error_reporting(1);

    //for DB_information.php
    $postdata = $_POST;
    if (count(username_exists($postdata)) > 0){ 
       $_SESSION['book_error'] = 'This user already exists!';
         header("location: ../../");
    } else {
        create_user($postdata);
        unset($_SESSION['book_error']);
         header("location: ../../");
    }
?>
