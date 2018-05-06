<!-- Navigation Start -->
        
<div class="navbar-fixed">
    <nav class="nav-extended" id="nav-colors">
        <div class="nav-wrapper">
            <div class="valign-wrapper brand-logo center brand_centering">
                <a href="#" class="brand-logo center"><img src="view/imgs/favicon/mainLogo.svg" height="48px" width="auto"></a>
            </div>
            <a href="#" data-target="menu_others" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down valign-wrapper">
                <li><a class="waves-effect waves-light scrollspy" href="#books">Our Books</a></li>
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
    <?php
        session_start();
        if(isset($_SESSION['user_name']) == 1 && $_SESSION['user_login'] === 'true'){
            print '<li class="center">Welcome back! <b>' . $_SESSION['user_name'] . '</b></li>';
        }
    ?>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect section scrollspy" href="#books">Our Books</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">More options</a></li>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect waves-purple" href="https://github.com/pepscrub/books"><i class="fab fa-github-alt"></i> Github Repo</a></li>
    <li><div class="divider"></div></li>
    <?php
    session_start();
        if($_SESSION['perm_type'] == 'admin' && isset($_SESSION['user_login'])){
            print '<li><a class="waves-effect modal-trigger" href="#add_user"><i class="fas fa-user-plus"></i>Create new User</a></li>';
            ?>
            <li><a class="waves-effect waves-teal" onClick="admin_page_ajax('books&edit_mode=true')"><i class="far fa-edit"></i>Edit Books</a></li>
            <?php
            print '<li><a class="waves-effect waves-green modal-trigger" href="#add_book"><i class="fas fa-plus"></i>Add a new book</a></li>';
        }
        if($_SESSION['user_login'] == 'true'){
            print '<li><a class="waves-effect waves-red modal-trigger" href="#logout_modal"><i class="fas fa-sign-out-alt"></i>Logout</a></li>';
        }else{
            print '<li><a class="waves-effect modal-trigger" href="#login_modal"><i class="fas fa-sign-in-alt"></i>Login</a></li>';
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
                <i class="fas fa-pencil-alt"></i>
            </a>
            <ul>
                <li><a class="btn-floating blue-grey waves-effect waves-light modal-trigger" href="#add_user"><i class="fas fa-user-plus"></i></a></li>
                <li><a class="btn-floating indigo accent-1 waves-effect waves-teal" onClick="admin_page_ajax('books&edit_mode=true')"><i class="fas fa-edit"></i></a></li>
                <li><a class="btn-floating green accent-3b waves-effect waves-red modal-trigger" href="#add_book"><i class="fas fa-plus"></i></a></li>
            </ul>
        </div>
        <?php
    }
?>
<!-- Navigation End -->