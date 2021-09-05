<?php
session_start();
include "../model/connection_db.php";

// get upload ip from users for pin on map 
$user_id = $_SESSION['user_id'];
$sql = mysqli_query($conn, "SELECT entries.serverIpAddress,files.upload_ip,COUNT(*) AS connection_count FROM files 
                                    INNER JOIN entries ON entries.serverIpAddress IS NOT NULL 
                                    GROUP BY entries.serverIpAddress,files.upload_ip") or die(mysqli_error($conn));

$result = mysqli_fetch_all($sql);

echo json_encode($result);

