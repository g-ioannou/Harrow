<?php 

include "../model/connection_db.php";

if(!isset($_GET["code"])) {
    exit("<p style='font-size:x-large;'>Can not find page..</p>");
    //exit("Can't find page!");
}

$code = $_GET["code"];


$getEmailQuery = mysqli_query($conn, "SELECT email FROM user WHERE token='$code'");
echo $getEmailQuery['email'];
if(mysqli_num_rows($getEmailQuery) == 0){
    exit("<p style='font-size:x-large;'>Can not find page..</p>");
    //exit("Can't find page.");
}


if(isset($_POST["password_re"])){
    $password = $_POST["password_re"];
    $password = sha1(md5($password)); //crypt password

    $row = mysqli_fetch_array($getEmailQuery);
    $email = $row["email"];

    $query = mysqli_query($conn,"UPDATE user SET password = '$password' WHERE email='$email'");

    if($query){
        #! DELETE OLD TOKEN->NULL
        #$query = mysqli_query($conn,"DELETE FROM resetpassword");
        $query = mysqli_query($conn,"UPDATE user SET token= NULL WHERE email='$email'");
        exit('<p style="color:   rgb(0, 41, 51);text-align: center;margin: 10%;font-size:x-large;">Password changed. You can now log in with your new password. <a style="color: red;" href="login.html">Log In</a></p>');
        
        
    }
    else{
        exit("Something went wrong.");
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../view/resetPassword.js"></script>
    <link rel="stylesheet" href="../view/resetPassword.css">
    <title>Reset Password</title>
</head>
<body>
    <form method="post">

        <h3>Change your password</h3>

        <div id="pass_error"></div>

        <div class="form-user">
            <p>To reset your password you have to change it.
            Please enter your new password.</p>

            <div class="form-change">
            <input type="password" class="form-control" id="password_re" placeholder="Password"
                name="password_re" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                title="Your password must be at least 8 characters long, contain at least one number, one symbol and have a mixture of uppercase and lowercase letters."
                required="">
            <span class="error_form" id="re_pass_error"></span>

            <!-- An element to toggle between password visibility -->
            <input type="checkbox" id="check_re">Show Password
            <br>
            </div>

            <div class=form-submit>
            <input type="submit" name="save_password_edit" class="btn btn-primary" value="Save"
                id="save_btn">  
            </div>

        </div>

    </form>


</body>
</html>