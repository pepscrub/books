<!-- Navigation Start -->
        
<div class="navbar-fixed">
    <nav class="nav-extended" id="nav-colors">
        <div class="nav-wrapper">
            <div class="valign-wrapper brand-logo center brand_centering">
            <?php
            if($_SESSION['perm_type'] == 'admin' && $_SESSION['edit_mode'] == 'true'){
                print '<h1 class="red-text text-accent-4 center margin-0 no-padding">EDITING MODE</h1>';
            }else{
                print '<a href="#" class="brand-logo center"><img src="view/imgs/favicon/mainLogo.svg" height="48px" width="auto"></a>';
            }
            if($_SESSION['edit_mode'] == 'false'){
                print '<a href="#" class="brand-logo center"><img src="view/imgs/favicon/mainLogo.svg" height="48px" width="auto"></a>';
            }
            ?>
            </div>
            <a href="#" data-target="menu_others" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down valign-wrapper">
                <li><a class="waves-effect waves-light">About Us</a></li>
                <li><a class="waves-effect waves-light scrollspy" href="#books">Our Books</a></li>
                <li><a class="waves-effect waves-light">Contact</a></li>
                <li><div class="waves-effect waves-light sidenav-trigger center" data-target="menu_others"><i class="material-icons center-align">more_vert</i></div></li>
            </ul>
        </div>
        <div class="progress margin-0" id="ajax_loader" style="visablity: hidden">
            <div class="indeterminate"></div>
        </div>
    </nav>
    <div id="nav-blur"></div>
</div>

<ul id="menu_others" class="sidenav">
    <div class="user-view no-padding">
        <img src="view/imgs/favicon/mainLogo.svg" height="48px" width="auto"></a>
    </div>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect">About Us</a></li>
    <li><a class="waves-effect section scrollspy" href="#books">Our Books</a></li>
    <li><a class="waves-effect">Contact</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">More options</a></li>
    <li><div class="divider"></div></li>
    <?php
    session_start();
        if($_SESSION['perm_type'] == 'admin' && isset($_SESSION['user_login'])){
            print '<li><a class="waves-effect">Anaylitics</a></li>';
            print '<li><a class="waves-effect">View Database</a></li>';
            ?>
            <li><a class="waves-effect waves-teal" onClick="admin_page_ajax('books&edit_mode=true')">Edit Books</a></li>
            <?php
            print '<li><a class="waves-effect waves-green modal-trigger" href="#add_book">Add a new book</a></li>';
        }
        if($_SESSION['user_login'] == 'true'){
            print '<li><a class="waves-effect waves-red modal-trigger" href="#logout_modal">Logout</a></li>';
        }else{
            print '<li><a class="waves-effect modal-trigger" href="#login_modal">Login</a></li>';
        }

    ?>
</ul>

<!-- Admin menu (red icon in the corner) -->
<?php
    error_reporting(0);
    session_start();
    if($_SESSION['perm_type'] == 'admin' && isset($_SESSION['user_login'])){
        ?>

        <div class="fixed-action-btn">
            <a class="btn-floating btn-large red">
                <i class="large material-icons">mode_edit</i>
            </a>
            <ul>
                <li><a class="btn-floating deep-orange accent-3 waves-effect waves-purple"><i class="fas fa-chart-pie"></i></a></li>
                <li><a class="btn-floating blue-grey waves-effect waves-light"><i class="fas fa-database"></i></a></li>
                <li><a class="btn-floating indigo accent-1 waves-effect waves-teal" onClick="admin_page_ajax('books&edit_mode=true')"><i class="fas fa-edit"></i></a></li>
                <li><a class="btn-floating green accent-3b waves-effect waves-red modal-trigger" href="#add_book"><i class="fas fa-book"></i></a></li>
            </ul>
        </div>
        <?php
    }
?>
<!-- Navigation End -->