<?php
session_start();
include "../../model/connection_db.php";

if (!isset($_SESSION['email'])) {
    header('location: ../../view/login/login.html');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <script src="/harrow/controller/edit_profile.js"></script>
    <script src="/harrow/view/style/home.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="/harrow/view/style/topbar.css">
    <link rel="stylesheet" href="/harrow/view/style/profile.css">
    <title>Edit profile</title>
</head>

<body>

    <div class="top-bar">
        <a class="logo"><img id="the-logo" src="/harrow/view/images/logo.png" alt=""></a>

        <a href="/harrow/view/home_user/home.php" class="btn action-btn"><i class="fal fa-home"></i></a>

        <a href="/harrow/view/home_user/files.php" class="btn action-btn"><i class="fal fa-file"></i></a>

        <a href="/harrow/view/home_user/heatmap.php" class="btn action-btn"><i class="fal fa-map-marked-alt"></i></a>
        <!--user logout-->
        <a class='nav-btn' id='logout-btn' href="/harrow/controller/logout.php"><i class="fal fa-door-open"></i></a>
        <!--Edit profile-->
        <a class='nav-btn' href="profile.php"><i class="fal fa-user"></i></a>

        <!-- Admin dashboard -->
        <button class='btn' id='admin-btn' type="button" hidden>Admin Dashboard</button>
    </div>

    <div class="spacer"></div>

    <div class="page">
        <br>
        <div class="action-buttons">
            <button type="button" class="btn btn-success btn-sm" id="main_username">Change your username</button>
            <button type="button" class="btn btn-success btn-sm" id="main_password">Change your password</button>
        </div>
        <br>
        <br>


        <!--Change username form-->

        <form action="/harrow/model/edit_profile.php" id="change_username" name="change_username" method="post">

            <h3>Change your username</h3>

            <div id="username_error"></div>

            <div class="form-user">
                <label for="username">Username</label><br>
                <input type="text" class="form-control" id="username_u" placeholder="username" name="username_u" required="">
                <span class="error_form" id="username_error_message"></span>
            </div>

            <div class="form-user">
                <label for="username">New username</label><br>
                <input type="text" class="form-control" id="new_username" placeholder="new username" name="new_username" required="">
                <span class="error_form" id="new_username_error"></span>
            </div>

            <div class="form-user">
                <label for="password">Password</label><br>
                <input type="password" class="form-control" id="password_user" placeholder="password" name="password_user" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters." required="">
                <br>
                <span class="error_form" id="pass_error_message"></span>
                <br>
                <!-- An element to toggle between password visibility -->

                <input type="checkbox" onchange="document.getElementById('password_user').type = this.checked ? 'text' : 'password'" /> Show password
                <br>
                <br>
                <input type="button" name="save_username_edit" class="btn btn-primary" value="Save changes" id="edit_user_btn">
                <br>
            </div>
        </form>



        <!--Change password form-->


        <form action="/harrow/model/edit_profile.php" id="change_password" name="change_password" method="post">

            <h3>Change your password</h3>

            <div id="pass_error"></div>

            <div class="form-user">
                <label for="username">Username</label><br>
                <input type="text" class="form-control" id="username_p" placeholder="username" name="username_p" required="">
                <span class="error_form" id="username_error_mess"></span>
            </div>

            <div class="form-user">
                <label for="password">Old password</label><br>
                <input type="password" class="form-control" id="old_password" placeholder="Old password" name="old_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters." required="">
                <span class="error_form" id="old_pass_error"></span>
                <br>



            </div>

            <div class="form-user">
                <label for="password">New password</label><br>
                <input type="password" class="form-control" id="new_password" placeholder="New password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" required="">
                <span class="error_form" id="new_pass_error"></span>

                <!-- An element to toggle between password visibility -->
                <br>

            </div>

            <div class="form-user">
                <label for="password">Re enter password</label><br>
                <input type="password" class="form-control" id="password_re" name="password_re" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters." required="">
                <span class="error_form" id="re_pass_error"></span>
                <br>
                <span>Show password</span><button id="show-new-pass"><i class="fas fa-eye-slash"></i></button>

                <br>

                <input type="button" name="save_password_edit" class="btn btn-primary" value="Save changes" id="edit_pass_btn">
            </div>

        </form>

    </div>
</body>

</html>