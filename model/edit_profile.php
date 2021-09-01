<?php 
    session_start();
    include "../model/connection_db.php";
    if(!isset($_SESSION['email'])){
        header('Location: ../view/home_user/home.php');
    }
    
    
    if($_POST['type'] == 3){
        $username  = $_POST["username"];
        $new_username = $_POST['new_username'];
        $password = $_POST['password'];
        $password = sha1(md5($password)); //crypt pass

        $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$username'");
        $num = mysqli_num_rows($query);
        $row = mysqli_fetch_array($query);
        
        if( $num == 1 ){ 
            $_SESSION['email'] = $row['email'];
            $sql = mysqli_query($conn, "UPDATE `users` SET username = '$new_username' WHERE username='$username' ");
            echo "success";
            $_SESSION['username'] = $new_username;
        }
        else if ($num>1){
            echo "fail_exists";
        }else{
            echo $new_username;
            echo $row['username'];
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

    $query = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '$username_p' AND `password`='$old_password' ");
    $num = mysqli_num_rows($query);
    $row = mysqli_fetch_array($query);

    if( $num == 1 ){
        echo "success";
        $sql = mysqli_query($conn, "UPDATE `users` SET password = '$new_password' WHERE password='$old_password' ");
    }
    else{
        echo "fail_pass";
    }

}
?>