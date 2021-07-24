<?php 
    session_start();
    include "connection_db.php";
    if(!isset($_SESSION['email'])){
        header('Location: home.php');
    }
    
    
    if($_POST['type'] == 3){
        $username  = $_POST["username_u"];
        $new_username = $_POST['new_username'];
        $password = $_POST['password'];
        $password = sha1(md5($password)); //crypt pass

        $query = mysqli_query($conn, "SELECT * FROM `user` WHERE `username` = '$username'");
        $num = mysqli_num_rows($query);
        $row = mysqli_fetch_array($query);
        
        if( $num > 0 ){ #?????????????????
            console.log("hi");
            $_SESSION['email'] = $row['email'];
            $sql = mysqli_query($conn, "UPDATE `user` SET username = '$new_username' WHERE username='$username' ");
            echo "success";
        }
        else{
            echo "fail";
        }
        

    } 

    if($_POST['type'] == 4){
    $username_p = $_POST['username_p'];
    $old_password = $_POST['old_password'];
    $old_password = sha1(md5($old_password)); //crypt password
    $new_password = $_POST['new_password'];
    $new_password = sha1(md5($new_password)); //crypt password
    $password_re =$_POST['password_re'];
    $password_re = sha1(md5($password_re)); //crypt password

    $query = mysqli_query($conn, "SELECT * FROM `user` WHERE `username` = '$username_p' AND `password`='$old_password' ");
    $num = mysqli_num_rows($query);
    $row = mysqli_fetch_array($query);

    if( $num == 1 ){
        echo "success";
        $sql = mysqli_query($conn, "UPDATE `user` SET password = '$new_password' WHERE password='$old_username' ");
    }
    else{
        echo "fail_pass";
    }

}   


?>