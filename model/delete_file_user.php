<?php
session_start();
include "../model/connection_db.php";

$user_id = $_SESSION['user_id'];
$file_id = $_POST['file_id'];
$sql = mysqli_query($conn, "CALL delete_file($user_id,$file_id)") or die(mysqli_error($conn));

echo 'ok';

?>