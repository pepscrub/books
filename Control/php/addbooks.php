<?php
    require '../../model/php/db_and_sensitive.php';

    //Sanitization of all fields in the form 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Checks if the method requested was post

        $name = !empty($_POST['name'])? test_user_input(($_POST['name'])) : null;
        $surname = !empty($_POST['surname'])? test_user_input(($_POST['surname'])) : null;
        $booktitle = !empty($_POST['BookTitle'])? test_user_input(($_POST['BookTitle'])) : null;
        $plotsource = !empty($_POST['PlotSource'])? test_user_input(($_POST['PlotSource'])) : null;
        $nationality = !empty($_POST['Nationality'])? test_user_input(($_POST['Nationality'])) : null;
        $yearofpublication = !empty($_POST['YearofPublication'])? test_user_input(($_POST['YearofPublication'])) : null;
        $birthyear = !empty($_POST['BirthYear'])? test_user_input(($_POST['BirthYear'])) : null;
        $deathyear = !empty($_POST['DeathYear'])? test_user_input(($_POST['DeathYear'])) : null;
        $genre = !empty($_POST['genre'])? test_user_input(($_POST['genre'])) : null;
        $book_language = !empty($_POST['book_langauge'])? test_user_input(($_POST['book_langauge'])) : null;
        $ogTitle = !empty($_POST['ogTitle'])? test_user_input(($_POST['ogTitle'])) : $booktitle;
        $msold = !empty($_POST['millionsSold'])? test_user_input(($_POST['millionsSold'])) : null;
        $score = !empty($_POST['rankingScore'])? test_user_input(($_POST['rankingScore'])) : null;


        $target_dir = '../../View/imgs/BookCovers/';
        $target_file = $target_dir . basename($_FILES["book_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        //FILE UPLOAD FOR PLOT


        if(isset($_POST['PlotSource'])){
            if($_FILES['plot']['type'] === 'text/plain' && preg_match('/txt/', $_FILES['plot']['name']) === 1){
                $plot = file_get_contents($_FILES['plot']['tmp_name']);
                $plot = preg_replace('/"/', '', $plot); //Replace any double quotes
                $plot = preg_replace('/\'/', '', $plot); //Replace any single quotes
                $plot = preg_replace('/\//', '', $plot); //Replace backslashes
                $plot = preg_replace('/{\/*}/', '', $plot); //Replace any multiline comments
                $plot = preg_replace('/;/', '', $plot); //Replace semi columns
                $plot = !empty($plot)? test_user_input($plot) : null;
            }
        }


        //FILE UPLOAD FOR IMAGES

        if(isset($_POST['BookTitle'])){//IF POST INFO EXISTS
            $check = getimagesize($_FILES["book_img"]["tmp_name"]); //If the image is a real image file
            if($check !== false) { 
                $uploadOk = 1;
            } else {
                $_SESSION['book_error'] =  "File is not an image.";
                $uploadOk = 0;
            }
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") { //If the tmp image does not end in the following file extension types
            $_SESSION['book_error'] =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if($uploadOk === 1){//If the upload proccess has been successfull 
            $book_img = file_get_contents($_FILES['book_img']['tmp_name']);
        }else{
            $book_img = file_get_contents('../../view/imgs/BookCovers/default.png');
        }



        $authorid = sql_insert_author($name, $surname, $nationality, $birthyear, $deathyear); //This function returns the last inserted id into the db (used this so if multiple books were added for multiple authors)
        $bookid = sql_insert_books($booktitle, $ogTitle, $yearofpublication, $genre, $msold, $book_language, $authorid, $book_img);

        sql_insert_plot($plot, $plotsource, $bookid);
        sql_insert_score($score, $bookid);
    }else{
        $_SESSION['access_deined'] == 1;
        header("location: ../../");

    }

    
    header("location: ../../");


    // print '<br>' . $plotsource;

    // print '<br>' . $score;
?>
