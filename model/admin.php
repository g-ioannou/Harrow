<?php
session_start();
include "../model/connection_db.php";
$email = $_SESSION['email'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND is_admin = 1");

$num = mysqli_num_rows($query);

if ($num == 1) {
    echo 'success';
} else {
    echo "fail";
}
?>