<?
session_start();
include "../model/connection_db.php";


$file_id = $_GET['file_id'];
$sql = mysqli_query($conn, "SELECT `file_id`,`serverIpAddress` FROM entries WHERE `file_id`='$file_id' AND `serverIpAddress` IS NOT NULL") or die(mysqli_error($conn));




$results  = array();



while ($row = mysqli_fetch_array($sql)) {
    $file_id = $row['file_id'];
    $entry_serverIpAddress = $row['serverIpAddress'];



    $results[] = array('file_id' => $file_id, 'serverIpAddress' => $entry_serverIpAddress);
}

echo json_encode($results);
