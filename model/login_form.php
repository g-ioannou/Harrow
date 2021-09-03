<?php
session_start();
include '../model/connection_db.php';

if ($_POST['type'] == "login") {
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password'])); //encrypt password
    $query = mysqli_query($conn, "CALL validate_login('$email','$password')") or die(mysqli_error($conn));
    $row = mysqli_fetch_array($query);
    if ($row['email'] == $email) {
        $query->close();
        $conn->next_result();


        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['avatar_seed'] = $row['avatar_seed'];

        if($row['is_admin']==1){
            echo 'success_admin';
        }else{
        
            echo 'success_user';
        }
    } else {
        session_destroy();
        echo "fail";
    }
}

if ($_POST['type'] == "register") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $password = sha1(md5($_POST['password']));
    $query = mysqli_query($conn, "CALL get_user('$email')");
    $row = mysqli_fetch_array($query);

    if ($username == $row['username']) {
        echo 'fail_user';
    } elseif ($email == $row['email']) {
        echo 'fail_email';
    } else {
        $query->close();
        $conn->next_result();

        if (!$sql = mysqli_query($conn, "CALL add_user('$email','$username','$password','$firstname','$lastname') ")) {
            echo mysqli_error(($conn));
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            echo 'success';
        }
    }
}
?>