<?php 

include "../model/connection_db.php";
include '../view/login/reset_password.html';

if(!isset($_GET["code"])) {
    exit("<p style='font-size:x-large;'>Can not find page..</p>");
    //exit("Can't find page!");
}

$code = $_GET["code"];


$getEmailQuery = mysqli_query($conn, "SELECT email FROM user WHERE token='$code'");

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
        exit('<p style="color:   rgb(0, 41, 51);text-align: center;margin: 10%;font-size:x-large;">Password changed. You can now log in with your new password. <a style="color: red;" href="/harrow/view/login/login.html">Log In</a></p>');
        
        
        
    }
    else{
        exit("Something went wrong.");
    }

}


?>

