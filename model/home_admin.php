<?php
session_start();


include '../model/connection_db.php';


$query = "SELECT id FROM user ORDER BY id";
$query_run = mysqli_query($conn, $query);

$row= mysqli_num_rows($query_run);

echo '<h1> '.$row.'</h1>';
?>