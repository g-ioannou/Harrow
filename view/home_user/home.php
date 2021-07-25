 <?php
    session_start();
    include "../../model/connection_db.php";
    if (!isset($_SESSION['email'])) {
        header('Location: ../view/login/login.html');
    }

    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="/harrow/controller/home.js"></script>
     <title>HOMEPAGE</title>
 </head>

 <body>
     <h1>Homepage</h1>
     <br>

     <!--Edit profile-->
     <a href="profile.php">Edit profile</a>


     <!--user logout-->
     <a href="/harrow/controller/logout.php">Logout</a>

     <button id='admin-btn' type="button" hidden>Admin Dashboard</button>
 </body>

 </html>