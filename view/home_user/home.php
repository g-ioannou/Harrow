<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: ../../view/login/login.html');
}
include "../../model/connection_db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/ip-geolocation-api-jquery-sdk@1.1.0/ipgeolocation.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="/harrow/view/style/topbar.css">
    <link rel="stylesheet" href="/harrow/view/style/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">


    <style type="text/css">
        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
    <script type="text/javascript" src="/harrow/view/style/home.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="top-bar">
        <a class="logo"><img id="the-logo" src="/harrow/view/images/logo_white_color.png" alt=""></a>

        <a href="/harrow/view/home_user/home.php" class="btn action-btn"><i class="fal fa-home"></i></a>

        <a href="/harrow/view/home_user/files.php" class="btn action-btn"><i class="fal fa-file"></i></a>

        <a href="/harrow/view/home_user/heatmap.php" class="btn action-btn"><i class="fal fa-map-marked-alt"></i></a>

        <!--user logout-->
        <a class='nav-btn' id='logout-btn' href="/harrow/controller/logout.html"><i class="fal fa-door-open"></i></a>
        <!--Edit profile-->
        <a class='nav-btn' href="profile.php"><i class="fal fa-user"></i></a>

        <!-- Admin dashboard -->
        <button class='btn' id='admin-btn' type="button" hidden>Admin Dashboard</button>
    </div>
    <div class="page">
        <div class="spacer"></div>
        <span id="welcome-icon"><i class="fad fa-grin-hearts"></i></span>

        <span id="hello-msg">Hi <?php echo $_SESSION['username'] ?>!</span>
        <div class="spacer"></div>

        <div class="statistics">
            <div class="isp-table">
                Number of files you uploaded from the specific ISP
                <table id="isp-count-table">
                    <tr>
                        <th>ISP</th>
                        <th># </th>
                    </tr>
                </table>
            </div>

            <div class="files-count">
                <table id="files-count">
                    <tr>
                        <th># Files uploaded</th>
                    </tr>
                    <tr>
                        <td>

                            <?php

                            $user_id = $_SESSION['user_id'];
                            $sql = mysqli_query($conn, "SELECT COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id ") or die(mysqli_error($conn));
                            $row = mysqli_fetch_row($sql);
                            echo $row[0];
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="city-count">
                Number of files by the place you were at the time of upload
                <table id="city-count">
                    <tr>
                        <th>Place</th>
                        <th>#</th>
                    </tr>
                    <?php
                    $user_id = $_SESSION['user_id'];

                    $sql = mysqli_query($conn, "SELECT upload_location,COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id GROUP BY upload_location ORDER BY file_count DESC") or die(mysqli_error($conn));

                    while ($row = mysqli_fetch_row($sql)) {

                        $place = $row[0];
                        $file_count = $row[1];
                        echo '<tr><td>' . $place . '</td><td>' . $file_count . '</td></tr>';
                    }
                    ?>
                </table>
            </div>

            Other statistics:
            <table id="other-statistics">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                $user_id = $_SESSION['user_id'];

                $sql = mysqli_query($conn, "SELECT COUNT(entries.entry_id) AS entries_count FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id") or die(mysqli_error($conn));

                $result = mysqli_fetch_row($sql);
                echo '<tr><td> Number of total entries</td><td>' . $result[0] . '</td></tr>';

                $sql = mysqli_query($conn, "SELECT COUNT(responses.response_id) AS response_count FROM responses INNER JOIN (SELECT entries.entry_id FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id) AS user_entries ON responses.entry_id = user_entries.entry_id")
                ?>
            </table>
        </div>
    </div>
</body>

</html>