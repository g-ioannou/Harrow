<?php

$servername = "localhost";
$username = "root";
$passworddb = "";
$dbname = "harrow";

// Create connection
$conn = new mysqli($servername, $username, $passworddb,$dbname);

// Check connection
if ($conn->connect_error) {
    
    die("Connection failed: " . $conn->connect_error);
}

?>