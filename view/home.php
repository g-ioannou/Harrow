<?php 
    session_start();
    include "connection_db.php";
    if(!isset($_SESSION['email'])){
        header('Location: login.html');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOMEPAGE</title>
</head>
<body>
    <h1>Homepage</h1>
    <br>

    <!--Edit profile-->
    <a href="profile.php">Edit profile</a>
    
    
    <!--user logout-->
    <a href="logout.php">Logout</a>
</body>

</html>