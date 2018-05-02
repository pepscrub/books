<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require '../../model/php/db_and_sensitive.php';
        session_start();
        $target_dir = '../../View/imgs/BookCovers/';
        $target_file = $target_dir . basename($_FILES["book_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        

        //If post update equals to delete, the user permissions are admin, the userlogin equals true, the previous page was the index.php page and edit mode was enabled
        //Then delete the book
        if($_POST['update'] === 'Delete' && $_SESSION['perm_type'] === 'admin' && $_SESSION['user_login'] === 'true' && $_SESSION['previous'] === 'index.php' && $_SESSION['edit_mode'] === 'true'){

            $delete_items = array( array('bookId' => $_POST['BookID'], 'tableName' => 'book'));

            sql_delete($delete_items);

            header("location: ../../");
        }

        // Code relating to if the form was updated
        else if($_POST['update'] === 'Update'  && $_SESSION['perm_type'] === 'admin' && $_SESSION['user_login'] === 'true' && $_SESSION['previous'] === 'index.php' && $_SESSION['edit_mode'] === 'true'){


            //Santization of all the input fields
            $authorid = !empty($_POST['AuthorID'])? test_user_input(($_POST['AuthorID'])) : null;
            $bookid = !empty($_POST['BookID'])? test_user_input(($_POST['BookID'])) : null;
            $name = !empty($_POST['name'])? test_user_input(($_POST['name'])) : null;
            $surname = !empty($_POST['surname'])? test_user_input(($_POST['surname'])) : null;
            $booktitle = !empty($_POST['BookTitle'])? test_user_input(($_POST['BookTitle'])) : null;
            $PlotSource = !empty($_POST['PlotSource'])? test_user_input(($_POST['PlotSource'])) : null;
            $nationality = !empty($_POST['Nationality'])? test_user_input(($_POST['Nationality'])) : null;
            $yearofpublication = !empty($_POST['YearofPublication'])? test_user_input(($_POST['YearofPublication'])) : null;
            $birthyear = !empty($_POST['BirthYear'])? test_user_input(($_POST['BirthYear'])) : null;
            $deathyear = !empty($_POST['DeathYear'])? test_user_input(($_POST['DeathYear'])) : null;
            $genre = !empty($_POST['Genre'])? test_user_input(($_POST['Genre'])) : null;
            $book_language = !empty($_POST['LanguageWritten'])? test_user_input(($_POST['LanguageWritten'])) : null;
            $ogTitle = !empty($_POST['ogTitle'])? test_user_input(($_POST['ogTitle'])) : $booktitle;
            $msold = !empty($_POST['millionSold'])? test_user_input(($_POST['millionSold'])) : null;
            $score = !empty($_POST['RankingScore'])? test_user_input(($_POST['RankingScore'])) : null;

            
            sql_update_author($authorid, $name, $surname, $nationality, $birthyear, $deathyear);



            if(isset($_FILES['book_img']) == 1){
                $check = getimagesize($_FILES["book_img"]["tmp_name"]); //If the image is a real image file
                if($check !== false) { 
                    $uploadOk = 1;
                }
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") { //If the tmp image does not end in the following file extension types
                $_SESSION['book_error'] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if($uploadOk === 1){//If the upload proccess has been successfull 
                $book_img = file_get_contents($_FILES['book_img']['tmp_name']); //Grabs the contents of the tmp file
                sql_update_books($bookid, $booktitle, $ogTitle, $yearofpublication, $genre, $msold, $book_language, $authorid, $book_img);
            }else{
                $_SESSION['book_error'] = ". Sorry, an error occured";
            }
            
            if(isset($_FILES['plot']) == 1){
                if($_FILES['plot']['type'] === 'text/plain' && preg_match('/txt/', $_FILES['plot']['name']) === 1){
                    $plot = file_get_contents($_FILES['plot']['tmp_name']);
                    $plot = preg_replace('/"/', '', $plot); //Replace any double quotes
                    $plot = preg_replace('/\'/', '', $plot); //Replace any single quotes
                    $plot = preg_replace('/[\]/', '', $plot); //Replace backslashes
                    $plot = preg_replace('/{\/*}/', '', $plot); //Replace any multiline comments
                    $plot = preg_replace('/;/', '', $plot); //Replace semi columns
                    $plot = !empty($plot)? test_user_input($plot) : null;
                    sql_update_plot($plot, $PlotSource, $bookid);
                }
            }
            sql_update_score($score, $bookid);
        }
        header("location: ../../");
    }
?>
