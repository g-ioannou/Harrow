 <?php
    // session_start();
    // include "../../model/connection_db.php";
    // if (!isset($_SESSION['email'])) {
    //     header('Location: ../view/login/login.html');
    // }

    ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

     <script type="text/javascript" src="/harrow/controller/home.js"></script>
     <script type="text/javascript" src="/harrow/view/style/home.js"></script>

     <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
     <link rel="stylesheet" href="/harrow/view/style/user.css">


     <title>Harrow</title>
 </head>

 <body>


     <div class="top-bar">
         <div class="logo">Homepage</div>

         <a href="/harrow/view/home_user/home.php" class="btn action-btn"><i class="fal fa-home"></i></a>


         <!--user logout-->
         <a class='nav-btn' id='logout-btn' href="/harrow/controller/logout.php"><i class="fal fa-door-open"></i></a>
         <!--Edit profile-->
         <a class='nav-btn' href="profile.php"><i class="fal fa-user"></i></a>


         <button class='btn' id='admin-btn' type="button" hidden>Admin Dashboard</button>
     </div>

     <div class="main">
         <div class="no-files">
             No files imported yet. Click button or drop to upload.<br>
             <i class="fal fa-file-import import-icon"></i>
         </div>

         <div class="upload-btn">

             <input type="file" id="upload-btn" accept=".json, .har" hidden multiple>
             <button id="fake-upload">Upload</button>

         </div>
         <br>
         <div class="new-files">
             <button id="hidden-display" hidden></button>
             Ready to be uploaded
             <div class="file-list">
                 <table class="file-table">
                     <th hidden><th>
                     <th>File Name</th>
                     <th>Size</th>
                     <th>Delete</th>
                     <th>Download Cleaned</th>
                     <div class="seperator"></div>
                 </table>
             </div>
             <button id="test">test</button>
         </div>
     </div>










 </body>

 </html>