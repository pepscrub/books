<?php
    session_start();

    //////////////////
    //DB CONNECTIONS//
    //////////////////

    function db_connect(){
        $conn = false;
        $conn = new PDO("mysql:host=localhost;dbname=mybooks", 'root', '');
        return $conn;
    }

    //-------------------------
    //Sanitisation 
    //-------------------------

    function test_user_input($form_data){
        $form_data = trim($form_data);
        $form_data = stripcslashes($form_data);
        $form_data = htmlspecialchars($form_data);
        $form_data = chop($form_data);
        $form_data = str_replace(';', '5441', $form_data);
        return $form_data;
    }

    //-------------------------
    //User login 
    //-------------------------


    function password_decryption($post_information){
        $username_sanitised = !empty($post_information['username'])? test_user_input(($post_information['username'])) : null;
        try{
            $conn = db_connect();
            $password_decrypt = 'SELECT `password` FROM `user_table` WHERE `username` = :username;';
            $stmt = $conn->prepare($password_decrypt);
            $stmt->bindParam(':username', $username_sanitised);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch (PDOException $e){
            exit(print 'Oops, something went wrong!' . $e->getMessage());
        }
    }


    function user_information($postinfo){
        try{
            $username_sanitised = !empty($postinfo['username'])? test_user_input(($postinfo['username'])) : null;
            $conn = db_connect();
            $userlogin = "SELECT * FROM user_table WHERE username = :username;";
            $stmt = $conn->prepare($userlogin);
            $stmt->bindParam(':username', $username_sanitised);
            $stmt->execute(); 
            $loginprocess = $stmt->fetchAll(PDO::FETCH_ASSOC); //Retrives information from the databas
            return $loginprocess;
        }catch (PDOException $e){
            exit(print 'Oops, something went wrong!' . $e->getMessage());
        }
    }

    //---------------------------------
    //Select statement functions
    //---------------------------------

    //Generic select function

    function sql_select($sql_statement){
        try{
            $conn = db_connect();
            $stmta = $conn->prepare($sql_statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmta->execute(); 
            return $stmta->fetchAll(PDO::FETCH_ASSOC); 
        }catch (PDOException $e){
            exit(print 'Oops, something went wrong!' . $e->getMessage());
        }
    }


    //---------------------------------
    // INSERT STATEMENTS FOR BOOKS
    //---------------------------------


    //Author insert
    //-------------

    function sql_insert_author($name, $surname, $nationality, $birthyear, $deathyear){
        try{
            if(count(sql_select('SELECT * FROM `author` WHERE `Name` = "' . $name . '" && `Surname` = "' . $surname . '";')) >= 1 ){
                $sql_statement = 'SELECT `AuthorID` FROM `author` WHERE `Name` = "' . $name . '" && `Surname` = "' . $surname . '";';
                $conn = db_connect();
                $stmta = $conn->prepare($sql_statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmta->execute(); 
                $results = $stmta->fetch(PDO::FETCH_ASSOC);
                $results = $results['AuthorID'];
            }else{
                $query = 'INSERT INTO `author` (`AuthorID`, `Name`, `Surname`, `Nationality`, `BirthYear`, `DeathYear`) 
                            VALUES (NULL, :name , :surname , :nationality , :birthyear , :deathyear);';
                $conn = db_connect();
                $stmta = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmta->bindParam(':name', $name);
                $stmta->bindParam(':surname', $surname);
                $stmta->bindParam(':nationality', $nationality);
                $stmta->bindParam(':birthyear', $birthyear);
                $stmta->bindParam(':deathyear', $deathyear);  
                $stmta->execute();
                $results = $conn->lastInsertId();
            }
            return $results;
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }
    
    //Books insert
    //------------
    //Used bind params for the image blob

    function sql_insert_books($booktitle, $originalTitle, $yearofpublication, $genre, $msold, $book_language, $authorId, $book_img){
        try{
            if(count(sql_select('SELECT `BookID` FROM `book` WHERE `BookTitle` = "' . $booktitle . '" && `LanguageWritten` = "' . $book_language . '";')) >= 1){
                $sql_statement = 'SELECT `BookID` FROM `book` WHERE `BookTitle` = "' . $booktitle . '" && `LanguageWritten` = "' . $book_language . '";';
                $conn = db_connect();
                $stmta = $conn->prepare($sql_statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmta->execute(); 
                $results = $stmta->fetch(PDO::FETCH_ASSOC);
                $results = $results['BookID'];
            }else{
                $query =    'INSERT INTO `book` (`BookID`, `BookTitle`, `OriginalTitle`, `YearofPublication`, `Genre`, `MillionsSold`, `LanguageWritten`, `AuthorID`, `BookIMG`) 
                            VALUES (NULL, ?,?,?,?,?,?,?,?);';
                $conn = db_connect();
                $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                $stmt->bindParam(1, $booktitle); 
                $stmt->bindParam(2, $originalTitle); 
                $stmt->bindParam(3, $yearofpublication); 
                $stmt->bindParam(4, $genre); 
                $stmt->bindParam(5, $msold); 
                $stmt->bindParam(6, $book_language); 
                $stmt->bindParam(7, $authorId); 
                $stmt->bindParam(8, $book_img);  
                $stmt->execute(); 
                $last_id = $conn->lastInsertId();
            }
            return $last_id;
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }

    //Plot insert
    //-----------

    function sql_insert_plot($plot, $plotsource, $bookid){
        try{
            $query =    'INSERT INTO `bookplot`(`BookPlotID`, `Plot`, `PlotSource`, `BookID`) 
                        VALUES (NULL, "' . $plot . '","' . $plotsource . '",' .  $bookid . ');';
            $conn = db_connect();
            $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }

    //Score insert 

    function sql_insert_score($rank, $bookid){
        try{
            $query =    'INSERT INTO `bookranking`(`RankingID`, `RankingScore`, `BookID`) 
                        VALUES (NULL, "' . $rank . '" , "' . $bookid . '")';
            $conn = db_connect();
            $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(); 
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }

    //---------------------------------
    //SQL UPDATE FUNCTIONS FOR BOOKS
    //---------------------------------

    //Author update
    //-------------

    function sql_update_author($authorid, $name, $surname, $nationality, $birthyear, $deathyear){
        try{
            $query = '
            UPDATE `author` SET 
            `Name`=?,
            `Surname`=?,
            `Nationality`=?,
            `BirthYear`=?,
            `DeathYear`=? 
            WHERE `AuthorID` = ?';
            $conn = db_connect();
            $stmta = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmta->bindParam(1, $name);
            $stmta->bindParam(2, $surname);
            $stmta->bindParam(3, $nationality);
            $stmta->bindParam(4, $birthyear);
            $stmta->bindParam(5, $deathyear);
            $stmta->bindParam(6, $authorid);  
            $stmta->execute();
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }
    
    //Books update
    //------------

    function sql_update_books($bookid, $booktitle, $originalTitle, $yearofpublication, $genre, $msold, $book_language, $authorId, $book_img){
        try{
            $query =    '
            UPDATE `book` SET 
            `BookTitle`= ?,
            `OriginalTitle`= ?,
            `YearofPublication`= ?,
            `Genre`= ?,
            `MillionsSold`= ?,
            `LanguageWritten`= ?,
            `AuthorID`= ?,
            `BookIMG`= ? 
            WHERE `BookID` = ?';
            $conn = db_connect();
            $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->bindParam(1, $booktitle); 
            $stmt->bindParam(2, $originalTitle); 
            $stmt->bindParam(3, $yearofpublication); 
            $stmt->bindParam(4, $genre); 
            $stmt->bindParam(5, $msold); 
            $stmt->bindParam(6, $book_language); 
            $stmt->bindParam(7, $authorId); 
            $stmt->bindParam(8, $book_img);  
            $stmt->bindParam(9, $bookid);  
            $stmt->execute(); 
            return 'successful';
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }

    //Plot update
    //-----------

    function sql_update_plot($plot, $plotsource, $bookid){
        try{
            $query =    'UPDATE `bookplot` SET 
            `Plot`= "' . $plot . '",
            `PlotSource`= "' . $plotsource . '"
            WHERE `bookID` = ' . $bookid . ';';
            $conn = db_connect();
            $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            return $query;
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }

    //Score update

    function sql_update_score($rank, $bookid){
        try{
            $query =    'UPDATE `bookranking` SET 
            `RankingScore`= "' . $rank . '"
            WHERE `BookID` = ' . $bookid .  ';';
            $conn = db_connect();
            $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(); 
        }catch (PDOException $e){
            return 'An error occured: ' . $e->getMessage();
        }
    }
    


    //Sql Delete
    //----------


    //Delete function
    //Requires a 3D array
    //Requires table name to be defined
    //Requires first item of third array to be the ID for row to be deleted
    //Requires the second item in the 3D array to be called tableName

    function sql_delete($item){
        if(is_array($item) == 1){
            $count = 1; //Used count for debugging purposes for the foreach loop
            foreach($item as $del_id){
                if(is_array($del_id) == 1){ //Checks if the 3D array exists
                    if(preg_match('/Id/', key($del_id)) === 1 || preg_match('/id/', key($del_id)) === 1 || preg_match('/ID/', key($del_id)) === 1){ //Checks if any of the keys contain ID
                        try{
                            $del_id_sanitized = !empty($del_id['tableName'])? test_user_input(($del_id['tableName'])) : null;
                            $del_key = key($del_id);

                            $query = 'DELETE FROM ' . $del_id_sanitized . ' WHERE ' . key($del_id) . ' = ' . $del_id[$del_key] . ';';
                            $conn = db_connect();
                            $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                            $stmt->execute(); 
                        }catch (PDOException $e){
                            exit('An error occured: ' . $e->getMessage());
                        }
                    }else{
                        exit('No ids found! You <u>must</u> start the 3D array with the keys as the book id <br> Count in the array:  ' . $count . ' item.');
                    }
                }else{
                    //Using exit method since it'll run one line and close the function instead of iterrating through the loop until its completed/ last loop
                    exit('Error inside array, the second part of the array is not an array <br> Entered Item: ' . $del_id);
                }
            }
        }else{
            return 'Items entered were not an array!';
        }    
        return 'Item was deleted!'; 
    }

    //Create a new account

    function create_user($postdata){
        //Field Sanitisation  
        $usr_name = !empty($postdata['reg_username'])? test_user_input(($postdata['reg_username'])) : null;
        $fname = !empty($postdata['reg_fname'])? test_user_input(($postdata['reg_fname'])) : null;
        $lname = !empty($postdata['reg_lname'])? test_user_input(($postdata['reg_lname'])) : null;
        $perm_type = !empty($postdata['reg_perm_type'])? test_user_input(($postdata['reg_perm_type'])) : null;

        //Password santisation and hashing
        $pass = !empty($postdata['reg_password'])? test_user_input(($postdata['reg_password'])) : null;
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT); //password hashing

        $insert_reg_sql = 'INSERT INTO `user_table` (username, password, perm_type, fname, lname) VALUES (?, ?, ?, ?, ?);';
        $conn = db_connect();
        $stmt = $conn->prepare($insert_reg_sql);
        $stmt->bindParam(1, $usr_name);
        $stmt->bindParam(2, $pass_hash);
        $stmt->bindParam(3, $perm_type);
        $stmt->bindParam(4, $fname);
        $stmt->bindParam(5, $lname);
        $result = $stmt->execute();
    }

    function username_exists($postdata){

        $username = !empty($postdata['reg_username'])? test_user_input(($postdata['reg_username'])) : null;

        $select_reg_sql = "SELECT username FROM user_table WHERE username = :username ;";
        $conn = db_connect();
        $stmt = $conn->prepare($select_reg_sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }

?>