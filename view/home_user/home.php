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
        <a class="logo"><img id="the-logo" src="/harrow/view/images/logo.png" alt=""></a>

        <a href="/harrow/view/home_user/home.php" class="btn action-btn"><i class="fal fa-home"></i></a>

        <a href="/harrow/view/home_user/files.php" class="btn action-btn"><i class="fal fa-file"></i></a>

        <a href="/harrow/view/home_user/heatmap.php" class="btn action-btn"><i class="fal fa-map-marked-alt"></i></a>

        <!--user logout-->
        <a class='nav-btn' id='logout-btn' href="/harrow/controller/logout.php"><i class="fal fa-door-open"></i></a>
        <!--Edit profile-->
        <a class='nav-btn' href="profile.php"><i class="fal fa-user"></i></a>

        <!-- Admin dashboard -->
        <button class='btn' id='admin-btn' type="button" hidden>Admin Dashboard</button>
    </div>
    <div class="page">

        <div class="avatar card">

            <?php
            $seed = $_SESSION['user_id'];
            echo '<img class="avatar-img" src="https://avatars.dicebear.com/api/avataaars/:' . $seed . '.svg?mood[]=happy" /> <br>';
            ?>
            Hi <?php echo $_SESSION['username'] ?>!
        </div>
        <div class="break"></div>
        <div id="home-msg-1" class="card">Here's what we've got so far</div>
        <div class="break"></div>
        <div class="card">
            <b>Number of files you have uploaded</b><br>
            <br>
            <i class="fas fa-tally"></i>
            <?php

            $user_id = $_SESSION['user_id'];
            $sql = mysqli_query($conn, "SELECT COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id ") or die(mysqli_error($conn));
            $row = mysqli_fetch_row($sql);
            echo $row[0];
            ?>
        </div>

        <div class="card">
            <b>Number of files uploaded by <i>place</i></b>
            <br>
            <br>
            <?php
            $user_id = $_SESSION['user_id'];

            $sql = mysqli_query($conn, "SELECT upload_location,COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id GROUP BY upload_location ORDER BY file_count DESC") or die(mysqli_error($conn));

            while ($row = mysqli_fetch_row($sql)) {

                $place = $row[0];
                $file_count = $row[1];

                echo  '<i class="fas fa-location"></i> ' . $place . ' : ' . $file_count . ' files';
            }
            ?>
            
        </div>

        <div class="card">
            <b>Your files contain</b> <br><br>
            <?php
            $user_id = $_SESSION['user_id'];

            $sql = mysqli_query($conn, "SELECT COUNT(entries.entry_id) AS entries_count FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id") or die(mysqli_error($conn));

            $result = mysqli_fetch_row($sql);
            echo '<i class="fas fa-file-code"></i> ' . $result[0] . ' total <i>entries</i>';

            $total_entries = $result[0];

            $sql = mysqli_query($conn, "SELECT COUNT(requests.method) AS get_count FROM requests INNER JOIN (SELECT entries.entry_id FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id) AS user_entries ON requests.entry_id = user_entries.entry_id WHERE requests.method='GET'");
            $result = mysqli_fetch_array($sql);

            $total_gets = $result[0];
            echo '<br><br>' . $result[0] . ' of which contain <i>GET</i>&nbsp; requests';

            $sql = mysqli_query($conn, "SELECT COUNT(requests.method) AS get_count FROM requests INNER JOIN (SELECT entries.entry_id FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id) AS user_entries ON requests.entry_id = user_entries.entry_id WHERE requests.method='POST'");
            $result = mysqli_fetch_array($sql);

            $total_posts = $result[0];
            echo '<br>' . $result[0] . ' of which contain <i>POST</i>&nbsp; requests';

            $other_request_methods = $total_entries - $total_gets - $total_posts;

            if ($other_request_methods>0) {
                echo $other_request_methods . 'contain other type of request methods';
            }

            ?>
        </div>

        <div class="card">
            You've uploaded files using these <i>Internet Service Providers</i><br>

            <?php
            $user_id = $_SESSION['user_id'];
            $sql = mysqli_query($conn, "SELECT upload_isp ,COUNT(*) AS file_count FROM files WHERE user_id=$user_id GROUP BY upload_isp") or die(mysqli_error($conn));
            while ($row = mysqli_fetch_array($sql)) {
                $isp = $row[0];
                $files = $row[1];
                echo '<br><i class="fas fa-network-wired"></i> ' . $isp . ' : ' . $files . ' files';
            }
            ?>
        </div>




        <!-- <div class="statistics">
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

                            // $user_id = $_SESSION['user_id'];
                            // $sql = mysqli_query($conn, "SELECT COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id ") or die(mysqli_error($conn));
                            // $row = mysqli_fetch_row($sql);
                            // echo $row[0];
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
                    // $user_id = $_SESSION['user_id'];

                    // $sql = mysqli_query($conn, "SELECT upload_location,COUNT(file_id) AS file_count FROM files WHERE user_id=$user_id GROUP BY upload_location ORDER BY file_count DESC") or die(mysqli_error($conn));

                    // while ($row = mysqli_fetch_row($sql)) {

                    //     $place = $row[0];
                    //     $file_count = $row[1];
                    //     echo '<tr><td>' . $place . '</td><td>' . $file_count . '</td></tr>';
                    // }
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
                // $user_id = $_SESSION['user_id'];

                // $sql = mysqli_query($conn, "SELECT COUNT(entries.entry_id) AS entries_count FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id") or die(mysqli_error($conn));

                // $result = mysqli_fetch_row($sql);
                // echo '<tr><td> Number of total entries</td><td>' . $result[0] . '</td></tr>';

                // $sql = mysqli_query($conn, "SELECT COUNT(responses.response_id) AS response_count FROM responses INNER JOIN (SELECT entries.entry_id FROM entries INNER JOIN files ON files.user_id = $user_id AND files.file_id = entries.file_id) AS user_entries ON responses.entry_id = user_entries.entry_id")
                ?>
            </table>
        </div> -->
    </div>
</body>

</html>