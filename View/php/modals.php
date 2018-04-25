<div id="login_modal" class="modal">
    <div class="modal-content">
        <form id="login-form" method="post" action="control/php/loginphp.php">
            <div class="row center">
                <h4>Please login</h4>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <i class="fas fa-user prefix"></i>
                    <input id="username" type="text" name="username">
                    <label for="username">Username</label>
                </div>
                <div class="input-field col s6">
                    <i class="fas fa-lock prefix"></i>
                    <input id="password" type="password" name="password">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Login"  class="waves-effect btn-flat"></input>
            </div>
        </form>
    </div>
</div>

<?php
    error_reporting(0);
    session_start();
    if($_SESSION['user_login'] == 'true'){
        ?>
            <div id="logout_modal" class="modal">
                <div class="modal-content">
                    <div class="row center">
                        <h4>Are you sure you want to log out?</h4>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">No</a>
                            <a href="control/php/logout.php" class="modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
    if($_SESSION['perm_type'] == 'admin'){
        ?>
            <div id="add_book" class="modal">
                <div class="row center">
                    <h4>Add a new book!</h4>
                </div>
                <div class="modal-content">
                    <form id="add_book_form" action="control/php/addbooks.php" method="post" enctype="multipart/form-data" >
                        <div class="row no-padding m-0">
                            <div class="col s6">
                                <input placeholder="First Name" id="first_name" class="truncate" type="text" name="name"></input>
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="col s6">
                                <input placeholder="Last Name"id="last_name"class="truncate" type="text" name="surname"></input>
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="row no-padding m-0">
                            <div class="col s6">
                                <input id="book_title" placeholder="Book Name" class="truncate" type="text" name="BookTitle"></input>
                                <label for="book_title">Book Name</label>
                            </div>
                            <div class="col s6">
                                <input id="book_og_title" placeholder="Original Book Name" class="truncate" type="text" name="ogTitle"></input>
                                <label for="book_og_title">Original Book Name (Leave blank if none)</label>
                            </div>
                        </div>

                        <div class="row no-padding m-0">
                            <div class="col s12">
                                <input class="truncate" id="plot_source" placeholder="https://plotsourcelink.example" type="text" name="PlotSource"></input>
                                <label for="plot_source">Plot Source</label>
                            </div>
                        </div>
                                    
                                    
                        <div class="row no-padding m-0">
                            <div class="col s6">
                                <div class="file-field input-field">
                                    <div class="btn grey darken-4 waves-effect waves-light">
                                        <span>Upload Image</span>
                                        <input type="file" name="book_img" id="book_img">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Book cover">
                                    </div>
                                </div>
                            </div>
                            <div class="col s6">
                                <div class="file-field input-field">
                                    <div class="btn grey darken-4 waves-effect waves-light">
                                        <span>Upload Text</span>
                                        <input type="file" name="plot" id="plot">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Plot file">
                                    </div>
                                </div>
                            </div>
                        </div>
                                    
                                    
                        <div class="row no-padding m-0">
                            <div class="col s12">
                                <input type="text" id="nationality" placeholder="Nationality" name="Nationality"></input>
                                <label for="nationality">Nationality of the author</label>
                            </div>
                        </div>
                                    
                                    
                        <div class="row no-padding m-0">
                            <div class="col s4">
                                <input type="text" id="publication_date" palceholder="1985" name="YearofPublication" class="datepicker"></input>
                                <label for="publication_date">Year the book was published</label>
                            </div>
                            <div class="col s4">
                                <input type="text" id="BirthYear" name="BirthYear" class="datepicker"></input>
                                <label for="BirthYear">Year of birth</label>
                            </div>
                            <div class="col s4">
                                <input type="text" name="DeathYear" class="datepicker"></input>
                                <label for="DeathYear">Year of death (leave blank if they're still alive)</label>
                            </div>
                        </div>
                                    
                                    
                        <div class="row no-padding m-0">
                            <div class="input-field col s6">
                                <select name="genre" form="add_book_form">
                                    <option value="" disabled selected>Pick a genre</option>
                                    <option value="Science fiction">Science fiction</option>
                                    <option value="Satire">Satire</option>
                                    <option value="Drama">Drama</option>
                                    <option value="Action and Adventure">Action and Adventure</option>
                                    <option value="Romance">Romance</option>
                                    <option value="Mystery">Mystery</option>
                                    <option value="Horror">Horror</option>
                                    <option value="Self Help">Self Help</option>
                                    <option value="Health">Health</option>
                                    <option value="Guide">Guide</option>
                                    <option value="Travel">Travel</option>
                                    <option value="Childrens">Childrens</option>
                                    <option value="Religion, Spirituality & New Age">Religion, Spirituality & New Age</option>
                                    <option value="Science">Science</option>
                                    <option value="History">History</option>
                                    <option value="Math">Math</option>
                                    <option value="Anthology">Anthology</option>
                                    <option value="Poetry">Poetry</option>
                                    <option value="Encyclopedias">Encyclopedias</option>
                                    <option value="Dictionaries">Dictionaries</option>
                                    <option value="Comics">Comics</option>
                                    <option value="Art">Art</option>
                                    <option value="Cookbooks">Cookbooks</option>
                                    <option value="Diaries">Diaries</option>
                                    <option value="Journals">Journals</option>
                                    <option value="Prayer books">Prayer books</option>
                                    <option value="Series">Series</option>
                                    <option value="Trilogy">Trilogy</option>
                                    <option value="Biographies">Biographies</option>
                                    <option value="Autobiographies">Autobiographies</option>
                                    <option value="Fantasy">Fantasy</option>
                                </select>
                                <label>Book Genre</label>
                            </div>
                            <div class="input-field col s6">
                                <select name="book_langauge" form="add_book_form">
                                    <option value="" disabled selected>Language Written in</option>
                                    <option value="English">English</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="Spanish">Spanish</option>
                                    <option value="Hindi">Hindi</option>
                                    <option value="Arabic">Arabic</option>
                                    <option value="Portuguese">Portuguese</option>
                                    <option value="Russian">Russian</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Bengali">Bengali</option>
                                </select>
                                <label>Book Language</label>
                            </div>
                        </div>
                                    
                                    
                        <div class="row no-padding m-0">
                            <div class="col s6 range-field">
                                <input name="millionsSold" type="range" value="0" id="millionsSold" min="0" max="1000"/>
                                <label for="millionsSold">Millions Sold</label>
                            </div>
                            <div class="col s6 range-field">
                                <input name="rankingScore" type="range" value="0" id="rankingScore" min="0" max="10"/>
                                <label for="rankingScore">The rank of this book!</label>
                            </div>
                        </div>
    
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col s2 offset-s8"><a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Cancel</a></div>
                                <input type="submit" href="#!" class="col s2 btn-flat green accent-3" value="Add book"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>




        <?php
    }

?>