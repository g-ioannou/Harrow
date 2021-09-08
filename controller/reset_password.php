<?php 

include "../model/connection_db.php";
include '../view/login/reset_password.html';

if(!isset($_GET["code"])) {
    exit("<div class='msg' style='font-size:large;'>Can not find page..</div>");
    //exit("Can't find page!");
}

$code = $_GET["code"];


$getEmailQuery = mysqli_query($conn, "SELECT email FROM users WHERE token='$code'");

if(mysqli_num_rows($getEmailQuery) == 0){
    exit("<div class='msg' style='font-size:large;'>Can not find page..</div>");
    //exit("Can't find page.");
}


if(isset($_POST["password_re"])){
    $password = $_POST["password_re"];
    $password = sha1(md5($password)); //crypt password

    $row = mysqli_fetch_array($getEmailQuery);
    $email = $row["email"];

    $query = mysqli_query($conn,"UPDATE users SET password = '$password' WHERE email='$email'");

    if($query){
        #! DELETE OLD TOKEN->NULL
        #$query = mysqli_query($conn,"DELETE FROM resetpassword");
        $query = mysqli_query($conn,"UPDATE users SET token= NULL WHERE email='$email'");
        exit("<div class='msg' style='color: darkorange;text-align: center;font-size:large;'>Password changed. You can now log in with your new password. <a style='color: red;' href='/harrow/view/login/login.html'>Log In</a></div>");
        
        
        
    }
    else{
        exit("Something went wrong.");
    }

}


?>

