<?php

session_start();
include '../model/connection_db.php';



if($_POST['type'] == 1){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = sha1(md5($password)); //crypt password

    $query = mysqli_query($conn, "SELECT * FROM `user` WHERE `email` = '$email' AND `password`='$password' ");
    $num = mysqli_num_rows($query);
    $row = mysqli_fetch_array($query);

    if( $num == 1 ){
        $_SESSION['email'] = $row['email'];
        echo "success";
    }
    else{
        echo "fail";
    }

}       

if($_POST['type'] == 2){

    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = sha1(md5($password)); //crypt password
    
    $query_email = mysqli_query($conn, "SELECT * FROM `user` WHERE `email` = '$email'");
    $query_username = mysqli_query($conn, "SELECT * FROM `user` WHERE `username` = '$username'");
    $num_email = mysqli_num_rows($query_email);
    $num_username = mysqli_num_rows($query_username);
    
    
    if( $num_email == 0){
        if( $num_username == 0){
            $sql = mysqli_query($conn, "INSERT INTO `user` ( `firstname`, `lastname`, `username`, `email`, `password`) VALUES ('$firstname','$lastname','$username','$email', '$password')");            
            
            $query_email = mysqli_query($conn, "SELECT * FROM `user` WHERE `email` = '$email'");
            $row = mysqli_fetch_array($query_email);
            $_SESSION['email'] = $row['email']; // OR $_SESSION['email'] = $email
            echo "success";
        }
        else {
            echo "fail_user";
        }   
    }
    else{
        echo "fail_email";
    }
}


?>