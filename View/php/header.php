<html>
    <!--    HEADER       -->
    <head>
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Materialize framework -->
        <link type="text/css" rel="stylesheet" href="view/materialize/css/materialize.min.css">
        <link type="text/scss" rel="stylesheet" href="view/materialize/css/materialize.sass">
        <script src="view/materialize/js/materialize.min.js" defer></script>


        <!-- Jquery and AJAX -->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous" defer></script>


        <!-- Local Files -->
        <script src="control/js/javascriptMain.js"></script>
        <?php
            error_reporting(0);
            session_start();
            if($_SESSION['perm_type'] == 'admin'){
                print '<script src="control/js/adminJavscript.js"></script>';
            }
        ?>
        <link type="text/css" rel="stylesheet" href="view/css/cssMain.css">

        <title>Bookmark</title>
            
    </head>
    <body>