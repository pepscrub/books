<?php
    session_start();
    require_once('model/php/db_and_sensitive.php');
    require_once('view/php/mainheader.php');


    //REPLACE WITH PROCEDURE


    $query_request = 'CALL displaybooks_by_million';
    $query_response = sql_select($query_request); //Grabs the information from the db
    get_books($query_response); //For the slider at the top of the page 
    $num = 0;
    $each_count = 0;
    $next_count = 3;
    $book_count = 0;

    
    ///////////////////////////
    //PRINTING BOOKS ONTO DOM//
    ///////////////////////////
    if($_SESSION['perm_type'] === 'admin' && $_SESSION['edit_mode'] === 'true'){
        print '<h2 class="center red-text text-darken-4" id="books"><b>EDITING MODE</b></h2>';
        print '<p class="center">It\'s dangerous to go alone take this! (there\'s nothing)</p>';
    }else{
        print '<h2 class="center" id="books">Our books!</h2>';
    }
    print '<div class="container">';
        foreach($query_response as $row){
            $book_count++;
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
            $rank = $row['RankingScore'] * 10;
            $plot = $row['Plot'];
            $plot_source = $row['PlotSource'];


            // Millions or Billions
            if($msold >= 1000){
                $msold = round($msold);
                $msold = $msold - 1000;
                $msold = $msold + 1;
                $mill_or_bill = 'Billion';
            }else{
                $mill_or_bill = 'Million';
            }
            
            // Calculating Age and setting status
            $curryear = date("Y");
            if($yod == ''){
                $alive = '<li class="collection-item"><b>Status </b><span class="right green-text text-accent-4">' . 'Alive' . '</span></li>';
                $age = $curryear - $yob;
            }else{
                $alive = '<li class="collection-item"><b>Status </b><span class="right red-text text-accent-4">' . 'Passed Away' . '</span></li>';
                $age = $yod - $yob;
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
                if($_SESSION['ping'] != 'high'){
                    if(!empty($row['BookIMG'])){
                        print '<img class="materialboxed margin-center" src="data:image/jpeg;base64,'. base64_encode($row['BookIMG']) .'" width="203" height="297"/>';
                    }else{
                        print '<img class="materialboxed margin-center" src="view/imgs/bookcovers/default.png" width="203" height="297"/>';
                    }
                }
                print '<ul class="collapsible expandable">';
                    print '<li>';
                    print   '<div class="progress white margin-0">
                                 <div class="determinate" style="width: ' . $rank . '%"></div>
                            </div>';
                    print '<div class="collapsible-header w">
                                <i class="' . $icon_class . '"></i><span class="truncate">' . $title . '</span>
                                <span class="new badge" data-badge-caption="' . $mill_or_bill . ' sold!">' . $msold  . '</span>
                            </div>';
                    print '<blockquote class="collapsible-body margin-0 no-padding">
                            <ul class="collection width-header">';
                            if($_SESSION['perm_type'] == 'admin' && $_SESSION['edit_mode'] == 'true'){
                                print '
                                <form action="control/php/deleteorupdatebooks.php" method="post" id="book_form_id_' . $book_count  . '" enctype="multipart/form-data"> 

                                    <!-- Delete book start -->

                                    <div id="delete_' . $book_count  . '" class="modal">
                                        <div class="modal-content">
                                            <div class="row center">
                                                <h4>Are you sure you want to delete: <b>' . $title . '</b></h4>
                                                <p>By ' . $fullname . '</p>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <a href="#!" class="modal-action modal-close waves-effect green waves-light btn-flat col s6 center white-text">Cancel</a>
                                                    <input type="submit" class="col s6 btn red accent-3" name="update" value="Delete"></input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Delete book end -->

                                    <input hidden type="number" value="' . $row['AuthorID'] . '" name="AuthorID"></input>
                                    <input hidden type="number" value="' . $row['BookID'] . '" name="BookID">
                                    <li class="collection">
                                        <div class="row no-padding margin-0">
                                            <div class="col s12">
                                                <div class="file-field input-field">
                                                    <div class="btn grey darken-4 waves-effect waves-light col s2">
                                                        <span><i class="fas fa-upload"></i></span>
                                                        <input type="file" name="book_img">
                                                    </div>
                                                    <div class="file-path-wrapper col s10">
                                                        <input class="file-path validate" type="text" placeholder="Book cover">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="file-field input-field">
                                                    <div class="btn grey darken-4 waves-effect waves-light col s2">
                                                        <span><i class="fas fa-upload"></i></span>
                                                        <input type="file" name="plot">
                                                    </div>
                                                    <div class="file-path-wrapper col s10">
                                                        <input class="file-path validate" type="text" placeholder="Plot summary">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection">
                                        <div class="row">
                                            <div class="col s2">
                                                <h5 class="fas fa-user prefix"></h5>
                                            </div>
                                            <div class="col s4 margin-0">
                                                <input required class="truncate" type="text" value="' . $fname . '" name="name"></input>
                                            </div>
                                            <div class="col s4 margin-0 no-padding">
                                                <input required class="truncate" type="text" value="' . $lname . '" name="surname"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item active center">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-book"></h5>
                                            </div>
                                            <div class="col s10">
                                                <input required class="truncate" type="text" value="' . $title . '" name="BookTitle"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item center">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-book"></h5>
                                            </div>
                                            <div class="col s10">
                                                <input class="truncate" type="text" value="' . $ogtitle . '" name="ogTitle"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-file-code"></h5>
                                            </div>
                                            <div class="col s10">
                                            <input required class="truncate" type="text" value="' . $plot_source . '" name="PlotSource"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-flag"></h5>
                                            </div>
                                            <div class="col">
                                            <input type="text" value="' . $nationality . '" name="Nationality"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-calendar"></h5>
                                            </div>
                                            <div class="col">
                                            <input required type="text" value="' . $Year_Pub . '" name="YearofPublication" class="datepicker"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-child"></h5>
                                            </div>
                                            <div class="col">
                                            <input required type="text" value="' . $yob . '" name="BirthYear" class="datepicker"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-times"></h5>
                                            </div>
                                            <div class="col">
                                            <input type="text" value="' . $yod . '" name="DeathYear" class="datepicker"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fab fa-angellist"></h5>
                                            </div>
                                            <div class="col">
                                            <input required type="text" value="' . $genre . '" name="Genre"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-language"></h5>
                                            </div>
                                            <div class="col">
                                                <input required type="text" value="' . $lang . '" name="LanguageWritten"></input>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-dollar-sign"></h5>
                                            </div>
                                            <div class="col s6 range-field">
                                            ';
                                            if($msold >= 1 && $mill_or_bill == 'Billion'){
                                                $msold = $msold + 999;
                                            }
                                            print '
                                                <input name="millionSold" type="range" value="' . $msold . '" min="0" max="1000"/>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="collection-item">
                                        <div class="row no-padding m-0">
                                            <div class="col">
                                                <h5 class="fas fa-star"></h5>
                                            </div>
                                            <div class="col">
                                                <input required type="text" value="' . $row['RankingScore'] . '" name="RankingScore"></input>
                                            </div>
                                        </div>
                                    </li>
                                <li class="collection-item no-padding">
                                    <div class="row no-padding margin-0">
                                        <button class="col s6 waves-effect waves-light btn red darken-1 modal-trigger" href="#delete_' . $book_count  . '">Delete Book</button>
                                        <input type="submit" class="col s6 btn green accent-3" name="update" value="Update" autofocus></input>
                                    </div>
                                </li>
                                </form>
                            </ul>
                    </blockquote>';
                            }else{
                            print'
                                <li class="collection-header"><h5 class="center active">' . $fullname . '</h5></li>
                                <li class="collection-item active center">' . $title . '</li>
                                <li class="collection-item"><p>' . $plot . '</p><a href="' . $plot_source . '" class="grey-text text-darken-2 truncate">-' . $plot_source . '</a></li>
                                ' . $alive . '
                                <li class="collection-item"><b>Nationality </b><span class="right">' . $nationality . '</span></li>
                                <li class="collection-item"><b>Year Published </b><span class="right">' . $Year_Pub . '</span></li>
                                <li class="collection-item"><b>Age </b><span class="right">' . $age . '</span></li>
                                <li class="collection-item"><b>Genre </b><span class="right">' . $genre . '</span></li>
                                <li class="collection-item"><b>Language written in </b><span class="right">' . $lang . '</span></li>
                            </ul>
                    </blockquote>';
                    }
                    print '</li>';
                print '</ul>';
            print '</div>';
        }
    print '</div>';
?>