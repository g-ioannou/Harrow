<?php 

    include "connection_db.php";
    //if(!isset($_SESSION['email'])){
     //   header('Location: home.php');
    //}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="edit_profile.js"></script>
    

    <title>Edit profile</title>
</head>

<body>

    <a href="home.php">Home</a>

    <br>
    <button type="button" class="btn btn-success btn-sm" id="main_username">Change your username</button>
    <button type="button" class="btn btn-success btn-sm" id="main_password">Change your password</button>
    <br>
    <br>


    <!--Change username form-->

    <form action="edit_form.php" id="change_username" name="change_username" method="post">

        <h3>Change your username</h3>

        <div id="username_error"></div>

        <div class="form-user">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username_u" placeholder="username" name="username_u" required="">
            <span class="error_form" id="username_error_message"></span>
        </div>

        <div class="form-user">
            <label for="username">New username:</label>
            <input type="text" class="form-control" id="new_username" placeholder="new username" name="new_username"
                required="">
            <span class="error_form" id="new_username_error"></span>
        </div>

        <div class="form-user">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password_user" placeholder="password" name="password_user"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters."
                required="">
            <span class="error_form" id="pass_error_message"></span>

            <!-- An element to toggle between password visibility -->
            <input type="checkbox" id="check_user">Show Password
            <br>

            <input type="button" name="save_username_edit" class="btn btn-primary" value="Save changes"
                id="edit_user_btn">

        </div>
    </form>



    <!--Change password form-->

    <form action="edit_form.php" id="change_password" name="change_password" method="post">

        <h3>Change your password</h3>

        <div id="pass_error"></div>

        <div class="form-user">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username_p" placeholder="username" name="username_p" required="">
            <span class="error_form" id="username_error_mess"></span>
        </div>

        <div class="form-user">
            <label for="password">Old password:</label>
            <input type="password" class="form-control" id="old_password" placeholder="Old password" name="old_password"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters."
                required="">
            <span class="error_form" id="old_pass_error"></span>

            <!-- An element to toggle between password visibility -->
            <input type="checkbox" id="check_old">Show Password
            <br>

        </div>

        <div class="form-user">
            <label for="password">New password:</label>
            <input type="password" class="form-control" id="new_password" placeholder="new password" name="new_password"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" required="">
            <span class="error_form" id="new_pass_error"></span>

            <!-- An element to toggle between password visibility -->
            <input type="checkbox" id="check_new">Show Password
            <br>

        </div>

        <div class="form-user">
            <label for="password">Re enter password:</label>
            <input type="password" class="form-control" id="password_re" placeholder="re enter password"
                name="password_re" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters."
                required="">
            <span class="error_form" id="re_pass_error"></span>

            <!-- An element to toggle between password visibility -->
            <input type="checkbox" id="check_re">Show Password
            <br>

            <input type="button" name="save_password_edit" class="btn btn-primary" value="Save changes"
                id="edit_pass_btn">
        </div>

    </form>


</body>

</html>





