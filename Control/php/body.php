<div id="loading_opacity" style="opacity: 0.4; filter: blur(2.5px);">
    <div id="loading_background"></div>
    <?php
        error_reporting(0);
        session_start();
        if($_SESSION['edit_reload_count'] >= 4){
            $_SESSION['edit_mode'] = 'false';
            $_SESSION['edit_reload_count'] = 0;
        }
        if($_GET['edit_mode'] == 'true'){
            $_SESSION['edit_mode'] = 'true';
            $_SESSION['edit_reload_count'] = $_SESSION['edit_reload_count'] + 1;
        }
        if($_GET['edit_mode'] == 'false'){
            $_SESSION['edit_mode'] = 'false';
        }

        if($_GET['ping'] == 'high'){
            $_SESSION['ping'] = 'high';
        }

        if($_GET['ping'] == 'low'){
            $_SESSION['ping'] = 'low';
        }

        if($_SESSION['edit_mode'] === 'true'){
            $_SESSION['edit_reload_count'] = $_SESSION['edit_reload_count'] + 1;
        }
        include 'view/php/mainheader.php';
        include 'view/php/books.php';
    ?>
