<div class="carousel carousel-slider center z-depth-1" id="header_slider">
    <div class="gradient_header">
        <div class="carousel-fixed-item center valign-center">
            <h1 class="margin-0 white-text text-bevel-shadow">BookMark</h1>
        </div>
        <?php
            error_reporting(0);
            session_start();
            function get_books($bookquery){
                $count_string = array("#one!","#two!","#three!","#four!","#five!","#six!","#seven!","#eight!","#nine!","#ten!","#eleven!","#twelve!","#thirteen!","#fourteen!","#fifthteen!","#sixteen!","#seventeen!","#eightteen!","#nineteen!","#twenty!");
                $count = 0;
                foreach($bookquery as $row){
                    print '<div class="carousel-item text-bottom" href="' . $count_string[$count] . '">';
                        //Reformatting code into a more human readable form
                        $title = $row['BookTitle'];
                        $fullname = $row['Name'] . ' ' . $row['Surname'];
                        print '<h4 class="center grey-text text-lighten-2 text-shadow-min">' . $title . '</h4>';
                        print '<p class="center grey-text text-darken-1 text-shadow-min"> -' . $fullname . '</p>';
                    print '</div>';


                    if(count($bookquery) == $count+1){ //Closing tags for the carousel
                        print '</div>
                        </div>';
                        if($_SESSION['perm_type'] == 'admin' && $_SESSION['edit_mode'] == 'true'){
                            print '<div><i class="far fa-bookmark bookmarkMain"></i></div>';
                        }else{
                            print '<div><i class="fas fa-bookmark bookmarkMain"></i></div>';
                        }
                    }
                $count++;
                }
            }
        ?>
