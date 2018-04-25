<?php
    session_start();
    unset($_SESSION['user_name']);
    unset($_SESSION['perm_type']);
    unset($_SESSION['user_login']);
    $_SESSION['logout'] = 'You\'ve logged out!';
    header("location: ../../");
?>
