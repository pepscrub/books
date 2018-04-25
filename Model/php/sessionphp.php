<?php
    session_start();
    //Destory the session if the user leaves the page
    $_SESSION['previous'] = basename($_SERVER['PHP_SELF']);

    if (isset($_SESSION['previous'])) {
        if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
            session_destroy();
        }
    }

    if($_SESSION['user_login'] === 'true'){
        unset($_SESSION['logout']);
    }


?>
