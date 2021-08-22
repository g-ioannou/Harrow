<?php
session_start();
include "../../model/connection_db.php";

if (!isset($_SESSION['email'])) {
    header('location: ../../view/login/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/ip-geolocation-api-jquery-sdk@1.1.0/ipgeolocation.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">


    <style type="text/css">
        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
    <script type="text/javascript" src="/harrow/controller/save_file.js"></script>
    <script type="text/javascript" src="/harrow/controller/geolocator.js"></script>
    <script type="text/javascript" src="/harrow/controller/files.js"></script>
    <script type="text/javascript" src="/harrow/view/style/files.js"></script>


    <link rel="stylesheet" href="/harrow/view/style/topbar.css">
    <link rel="stylesheet" href="/harrow/view/style/files.css">



    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <title>Harrow</title>
</head>

<body>
    <div class='notifications-side' hidden>
        <div class="notification-actions">

            <button id="clear-notifications"><i class="fas fa-trash-alt"></i></button>
            <button id="close-side-notifications"><i class="fas fa-times"></i></button>
        </div>
        <div class="notifications"></div>

    </div>




    <div class="page">

        <div class="top-bar">
            <div class="logo">Homepage</div>

            <a href="/harrow/view/home_user/home.php" class="btn action-btn"><i class="fal fa-home"></i></a>

            <a href="/harrow/view/home_user/files.php" class="btn action-btn"><i class="fal fa-file"></i></a>

            <a href="/harrow/view/home_user/heatmap.php" class="btn action-btn"><i class="fal fa-map-marked-alt"></i></a>

            <button class="nav-btn notification-list-btn btn"><i class="fas fa-bell"></i></button>

            <!--user logout-->
            <a class='nav-btn' id='logout-btn' href="/harrow/controller/logout.php"><i class="fal fa-door-open"></i></a>
            <!--Edit profile-->
            <a class='nav-btn' href="profile.php"><i class="fal fa-user"></i></a>

            <!-- Admin dashboard -->
            <button class='btn' id='admin-btn' type="button" hidden>Admin Dashboard</button>
        </div>

        <div class="spacer">

        </div>

        <!-- New files area -->
        <div class="new-files">
            <button id="hidden-display" hidden></button>
            <div id="ready-to-upload-msg">
                <span><b>Newly uploaded files</b></span><br>
                <span style="font-size:0.8em;color:rgb(149, 157, 165)">All sensitive data will removed during upload and you may download the sanitized file :)</span>
            </div>
            <br>
            <div class="file-list">

                <table id="new-files-table" class="file-table">

                    <th></th>
                    <th><i class="fas fa-file"></i></th>
                    <th><i class="fas fa-save"></i></th>
                    <th><i class="fas fa-trash-alt"></i></th>
                    <th><i class="fas fa-download"></i></th>

                </table>
                <div class="no-files">
                    No files imported yet. Click button or drop to upload.<br>
                    <i class="fal fa-file-import import-icon"></i>
                </div>
            </div>

            <button id="select-all-new" class="btn">Select all</button>

            <div class="upload-btn">
                <input type="file" id="upload-btn" accept=".json, .har" hidden multiple>
                <button id="fake-upload"><i class="fas fa-upload"></i> Upload</button>
            </div>

            <button id="delete-multiple-new-btn" class="btn" disabled='disabled'><i class="fas fa-trash-alt"></i> Delete </button>
            <button id="download-multiple-new-btn" class="btn" disabled='disabled'><i class="fas fa-download"></i> Download </button>
            <button id="save-to-server-btn" class="btn" disabled='disabled'><i class="fas fa-cloud-upload"></i> Save</button>
            <div id='selected-uploaded-files-msg'>
                <span id="selected-uploaded-files-number">0</span> files selected
            </div>

        </div>
    </div>

    <div class="spacer"></div>
    <!-- old files area -->
    <div class="old-files">
        <div id="already-uploaded-msg"><span><b>Your files</b></span></div><br>
        <div class="file-list">
            <table class="file-table" id='old-files-table'>

                <th></th>
                <th><i class="fas fa-file"></i></th>
                <th><i class="fas fa-save"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
                <th><i class="fas fa-download"></i></th>

            </table>

        </div>

    </div>


</body>

</html>