<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require '../../model/php/db_and_sensitive.php';
        session_start();


        //If post update equals to delete, the user permissions are admin, the userlogin equals true, the previous page was the index.php page and edit mode was enabled
        //Then delete the book
        if($_POST['update'] === 'Delete' && $_SESSION['perm_type'] === 'admin' && $_SESSION['user_login'] === 'true' && $_SESSION['previous'] === 'index.php' && $_SESSION['edit_mode'] === 'true'){

            $delete_items = array( array('bookId' => $_POST['BookID'], 'tableName' => 'book'), array('authorId' => $_POST['AuthorID'], 'tableName' => 'author') );

            sql_delete($delete_items);

            header("location: ../../");
        }
        else if($_POST['update'] === 'Update'){
            // Code
        }
        header("location: ../../");
    }
?>
