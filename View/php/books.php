<?php
    require_once('model/php/db_and_sensitive.php');

    $query_request = 'SELECT * FROM `book` INNER JOIN `author` ON `author`.`AuthorID` = `book`.`AuthorID` ORDER BY `MillionsSold` DESC;';
    $query_response = sql_select($query_request);
    $num = 0;
    $each_count = 0;
    $next_count = 3;


    ///////////////////////////
    //PRINTING BOOKS ONTO DOM//
    ///////////////////////////
    print '<div class="container">';
        foreach($query_response as $row){
            //Reformatting code into a more human readable form

            $msold = $row['MillionsSold'];
            $title = $row['BookTitle'];
            $ogtitle = $row['OriginalTitle'];
            $Year_Pub = $row['YearofPublication'];
            $genre = $row['Genre'];
            $lang = $row['LanguageWritten'];
            $fname = $row['Name'];
            $lname = $row['Surname'];
            $fullname = $fname . ' ' . $lname;
            $nationality = $row['Nationality'];
            $yob = $row['BirthYear'];
            $yod = $row['DeathYear'];



            //Calculating Age and setting status

            $curryear = date("Y");
            if($yod == ''){
                $alive = '<li class="collection-item"><b>Status </b><span class="right green-text text-accent-4">' . 'Alive' . '</span></li>';
                $age = $curryear - $yob;
            }else{
                $alive = '<li class="collection-item"><b>Status </b><span class="right red-text text-accent-4">' . 'Passed Away' . '</span></li>';
                $age = $yod - $yob;
            }


            //Images
            $img = preg_replace('/ /', '', $row['BookTitle']); //Remopves the spaces from the string
            $img = preg_replace('/:/', '', $img); //Remopves columns from the string
            $img = preg_replace('/\'/', '', $img); //Remopves single quote from the string
            $img = preg_replace('/,/', '', $img); //Remopves comma from the string
            $img = preg_replace('/;/', '', $img); //Remopves semi-column from the string
            $img = strip_tags($img); //Remopves the spaces from the string
            $img = $img . '.jpg'; //adds the tag .jpg onto the end

            //Testing if the file exists or not

            $url = 'http://localhost/books/view/imgs/bookcovers/' . $img;
            $status = get_http_response_code($url);
            if($status == 404){
                $img = 'default.png';
            }


            //Setting icons based on genre
            if(preg_match('/Fantasy/', $genre) === 1){
                $icon_class = 'fab fa-d-and-d';
            }
            if(preg_match('/Novel/', $genre) === 1){
                $icon_class = 'fas fa-book';
            }
            if(preg_match('/Fiction/', $genre) === 1){
                $icon_class = 'fab fa-studiovinari';
            }
            if(preg_match('/Fable/', $genre) === 1){
                $icon_class = 'fab fa-pied-piper-hat';
            }


            //Row counter to print 3 columns in each row and place a div tag at the end

            if($num === 0){
                print '<div class="row">';
                $each_count = $each_count + 3;
            }
            if($num === $each_count && $num != 0){
                print '</div>';
                print '<div class="row">';
                $each_count = $each_count + 3;
            }
            ++$num;

            print '<div class="col s4">';
                print '<img class="materialboxed margin-center" src="view/imgs/bookcovers/' . $img . '">';
                print '<ul class="collapsible expandable">';
                    print '<li>';
                    print '<div class="collapsible-header w">
                                <i class="' . $icon_class . '"></i><span class="truncate">' . $title . '</span>
                                <span class="new badge" data-badge-caption="Million sold!">' . $msold  . '</span>
                            </div>';
                    print '<blockquote class="collapsible-body margin-0 no-padding">
                            <ul class="collection width-header">
                                <li class="collection-header"><h5 class="center active">' . $fullname . '</h5></li>
                                <li class="collection-item active center">' . $title . '</li>
                                ' . $alive . '
                                <li class="collection-item"><b>Nationality </b><span class="right">' . $nationality . '</span></li>
                                <li class="collection-item"><b>Year Published </b><span class="right">' . $Year_Pub . '</span></li>
                                <li class="collection-item"><b>Age </b><span class="right">' . $age . '</span></li>
                                <li class="collection-item"><b>Genre </b><span class="right">' . $genre . '</span></li>
                                <li class="collection-item"><b>Language written in </b><span class="right">' . $lang . '</span></li>
                            </ul>
                    </blockquote>';
                    print '</li>';
                print '</ul>';
            print '</div>';
        }
    print '</div>';
?>
