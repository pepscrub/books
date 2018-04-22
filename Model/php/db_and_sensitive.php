<?php

function db_connect(){
    $conn = false;
    $conn = new PDO("mysql:host=localhost;dbname=mybooks", 'root', '');
    return $conn;
}

function get_http_response_code($domain){
    $headers = get_headers($domain);
    return substr($headers[0], 9, 3);
}


function sql_select($sql_statement){
    $conn = db_connect();
    $stmta = $conn->prepare($sql_statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmta->execute(); 
    return $stmta->fetchAll(); 
}

function sql_insert($query){
    if(is_string($query) === true){ 
        try{ 
                $conn = EstablishDBCon(); 
                $stmt = $conn->prepare($query); 
                $stmt->execute();
        }catch (PDOException $e){
                print 'Connection failed: ' . $e;
        }
    }else{
        exit(print '<h1>Function conainted a param that was not a string!</h1>');
    }
}
  


?>