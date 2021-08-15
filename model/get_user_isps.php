<?php
session_start();
include "../model/connection_db.php";


$user_id = $_SESSION['user_id'];
$sql = mysqli_query($conn, "SELECT upload_isp,COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id GROUP BY upload_isp ORDER BY file_count DESC") or die(mysqli_error($conn));

$results  = array();


while ($row = mysqli_fetch_array($sql)) {
    $isp = $row['upload_isp'];
    $file_count = $row['file_count'];
    $results[] = array('isp' => $isp, 'file_count' => $file_count);
}

echo json_encode($results);