<?php
session_start();
include '../model/connection_db.php';



if ($_POST['type'] == 'initial_choices_isp') {
    $query = "SELECT DISTINCT(upload_isp) AS upload_isp FROM files";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $upload_isp = mysqli_fetch_all($query_run);

    echo json_encode($upload_isp);
}


if ($_POST['type'] == 'initial_choices_content_type') {
    $query = mysqli_query($conn, "SELECT DISTINCT(content_type) FROM headers WHERE content_type IS NOT NULL") or die(mysqli_error($conn));

    $result = mysqli_fetch_all($query);

    echo json_encode($result);
}




if ($_POST['type'] == "initial_choices_method") {
    $query = "SELECT DISTINCT(method) FROM requests WHERE method IS NOT NULL AND method NOT LIKE ''";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $result = mysqli_fetch_all($query_run);

    echo json_encode($result);
}


if ($_POST['type'] == "content_types") {
    $times = array(
        "00:00:00", "00:59:59", "01:00:00", "01:59:59", "02:00:00", "02:59:59", "03:00:00", "03:59:59", "04:00:00", "04:59:59",
        "05:00:00", "05:59:59", "06:00:00", "06:59:59", "07:00:00", "07:59:59", "08:00:00", "08:59:59", "09:00:00", "09:59:59", "10:00:00", "10:59:59", "11:00:00", "11:59:59", "12:00:00", "12:59:59",
        "13:00:00", "13:59:59", "14:00:00", "14:59:59", "15:00:00", "15:59:59", "16:00:00", "16:59:59", "17:00:00", "17:59:59",
        "18:00:00", "18:59:59", "19:00:00", "19:59:59", "20:00:00", "20:59:59", "21:00:00", "21:59:59", "22:00:00", "22:59:59", "23:00:00", "23:59:59"
    );

    $time_index = 0;

    $content_list = $_POST['content_list'];

    for ($i = 0; $i < 24; $i++) {
        $time_1 = $times[$time_index];
        $time_2 = $times[$time_index + 1];

        foreach ($content_list as $content_type) {
            $query = mysqli_query($conn, "SELECT AVG(entries.wait) FROM `headers` RIGHT JOIN responses ON responses.response_id =headers.response_id INNER JOIN entries ON entries.entry_id = responses.entry_id WHERE headers.content_type= '$content_type' AND cast(entries.startedDateTime as Time) 
            BETWEEN '$time_1' AND '$time_2' ");
        }
        $content_type = mysqli_fetch_array($query);
        $content_type = $content_type['content_type'];
        $time_index = $time_index + 2;
        $data[$i] = $content_type;
    }
}



if ($_POST['type'] == "regs") {

    $query = "SELECT COUNT(user_id) AS user_count FROM users ";
    $query_run = mysqli_query($conn, $query);
    $user_count = mysqli_fetch_array($query_run);
    $user_count = $user_count["user_count"];
    echo $user_count;
}



if ($_POST['type'] == "methods") {
    $query = "SELECT method, count(*) AS method_count FROM requests GROUP BY method ORDER BY method_count DESC";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $results = mysqli_fetch_all($query_run);

    foreach ($results as $row) {
        echo "<b>$row[0]</b>:$row[1]<br>";
    }
}



if ($_POST['type'] == "status") {

    $sql = mysqli_query($conn, "SELECT status,count(*) AS status_count FROM  responses WHERE status IS NOT NULL GROUP BY  status  ORDER BY status_count DESC") or die(mysqli_error($conn));
    $results = mysqli_fetch_all($sql);
    foreach ($results as $row) {
        echo "<b>$row[0]</b>:$row[1]<br>";
    }
}


if ($_POST['type'] == "domain") {

    $query = "SELECT COUNT(DISTINCT url ) AS domain_count FROM requests";
    $query_run = mysqli_query($conn, $query);
    $domain_count = mysqli_fetch_array($query_run);
    $domain_count = $domain_count["domain_count"];
    echo $domain_count;
}

if ($_POST['type'] == "isps") {
    $query = "SELECT COUNT(DISTINCT upload_isp ) AS isp_count FROM files";
    $query_run = mysqli_query($conn, $query);
    $isp_count = mysqli_fetch_array($query_run);
    $isp_count = $isp_count["isp_count"];
    echo $isp_count;
}
if ($_POST['type'] == "isp") {

    $query = "SELECT COUNT(DISTINCT upload_isp ) AS isp_count FROM files";
    $query_run = mysqli_query($conn, $query);
    $isp_count = mysqli_fetch_array($query_run);
    $isp_count = $isp_count["isp_count"];
    echo $isp_count;
}

if ($_POST['type'] == "average") {

    $query = "SELECT DISTINCT content_type  AS content_type FROM headers WHERE content_type IS NOT NULL";
    $query_run = mysqli_query($conn, $query);
    $cont = [];
    while ($content_type = mysqli_fetch_array($query_run)) {
        $cont[] = $content_type['content_type'];
    }

    foreach ($cont as &$value) {



        $query = "SELECT AVG(age) AS avrg FROM headers WHERE content_type ='$value'";
        $query_run = mysqli_query($conn, $query);
        if (!$query_run) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        $avrg = mysqli_fetch_array($query_run);
        $avrg = $avrg["avrg"];
        if ($avrg == NULL) {
            echo "<b>", $value, "</b>", " : 0";
            echo "<br>";
        } else {
            echo "<b>", $value, "</b>", " : ", $avrg;
            echo "<br>";
        }
    }
}


/**
 * 
 * 
 *      
 *                      CHARTS
 * 
 * 
 * 
 */


if ($_POST["type"] == 'avg_wait_chart') {

    $k = array(
        "00:00:00", "00:59:59", "01:00:00", "01:59:59", "02:00:00", "02:59:59", "03:00:00", "03:59:59", "04:00:00", "04:59:59",
        "05:00:00", "05:59:59", "06:00:00", "06:59:59", "07:00:00", "07:59:59", "08:00:00", "08:59:59", "09:00:00", "09:59:59", "10:00:00", "10:59:59", "11:00:00", "11:59:59", "12:00:00", "12:59:59",
        "13:00:00", "13:59:59", "14:00:00", "14:59:59", "15:00:00", "15:59:59", "16:00:00", "16:59:59", "17:00:00", "17:59:59",
        "18:00:00", "18:59:59", "19:00:00", "19:59:59", "20:00:00", "20:59:59", "21:00:00", "21:59:59", "22:00:00", "22:59:59", "23:00:00", "23:59:59"
    );
    $z = 0;

    for ($i = 0; $i < 24; $i++) {
        $time_1 = $k[$z];
        $time_2 = $k[$z + 1];

        $query = "SELECT  AVG(wait) AS avg_wait FROM entries WHERE cast(startedDateTime as Time) BETWEEN '$time_1' AND '$time_2'  ";

        $query_run = mysqli_query($conn, $query);
        if (!$query_run) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        $avg_wait = mysqli_fetch_array($query_run);

        $avg_wait = $avg_wait['avg_wait'];
        $z = $z + 2;
        $data[$i] = $avg_wait;
    }


    echo json_encode($data);
}

if ($_POST['type'] == 'days_chart') {
    $hours = array(
        "00:00:00", "00:59:59", "01:00:00", "01:59:59", "02:00:00", "02:59:59", "03:00:00", "03:59:59", "04:00:00", "04:59:59",
        "05:00:00", "05:59:59", "06:00:00", "06:59:59", "07:00:00", "07:59:59", "08:00:00", "08:59:59", "09:00:00", "09:59:59", "10:00:00", "10:59:59", "11:00:00", "11:59:59", "12:00:00", "12:59:59",
        "13:00:00", "13:59:59", "14:00:00", "14:59:59", "15:00:00", "15:59:59", "16:00:00", "16:59:59", "17:00:00", "17:59:59",
        "18:00:00", "18:59:59", "19:00:00", "19:59:59", "20:00:00", "20:59:59", "21:00:00", "21:59:59", "22:00:00", "22:59:59", "23:00:00", "23:59:59"
    );
    $interval = 0;

    
    $sql = mysqli_query($conn, "SELECT DISTINCT(DAYNAME(startedDateTime)) AS day FROM `entries`;") or die(mysqli_error($conn));

    $days = mysqli_fetch_all($sql);
    
    $days_array = array();

    foreach ($days as $row) {
         $day = $row[0];
         
         for ($i = 0; $i < 24; $i++) {
             $time_1 = $hours[$interval];
             $time_2 = $hours[$interval + 1];
            
             
            $sql = mysqli_query($conn, "SELECT AVG(wait) AS avg_wait FROM entries WHERE DAYNAME(startedDateTime)= '$day' AND CAST(startedDateTime as Time) BETWEEN '$time_1' AND '$time_2' ") or die(mysqli_error($conn));
            

            $avg_wait = mysqli_fetch_array($sql);

            $avg_wait = $avg_wait['avg_wait'];
            $interval = $interval + 2;

            $data[$day][$i] = $avg_wait;
        }
        $interval = 0;
    }

    echo json_encode($data);
}


if ($_POST["type"] == 'content_type_chart') {

    $hours = array(
        "00:00:00", "00:59:59", "01:00:00", "01:59:59", "02:00:00", "02:59:59", "03:00:00", "03:59:59", "04:00:00", "04:59:59",
        "05:00:00", "05:59:59", "06:00:00", "06:59:59", "07:00:00", "07:59:59", "08:00:00", "08:59:59", "09:00:00", "09:59:59", "10:00:00", "10:59:59", "11:00:00", "11:59:59", "12:00:00", "12:59:59",
        "13:00:00", "13:59:59", "14:00:00", "14:59:59", "15:00:00", "15:59:59", "16:00:00", "16:59:59", "17:00:00", "17:59:59",
        "18:00:00", "18:59:59", "19:00:00", "19:59:59", "20:00:00", "20:59:59", "21:00:00", "21:59:59", "22:00:00", "22:59:59", "23:00:00", "23:59:59"
    );
    $interval = 0;
    $content_type_array = array();

    $query = "SELECT DISTINCT(content_type) AS content_type FROM headers ";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));


    $content_types = mysqli_fetch_all($query_run);
    $content_type_array = array();


    foreach ($content_types as $row) {
        $content_type = $row[0];


        for ($i = 0; $i < 24; $i++) {

            $time_1 = $hours[$interval];
            $time_2 = $hours[$interval + 1];


            $query = "SELECT AVG(entries.wait) AS avg_wait FROM `headers` RIGHT JOIN responses ON responses.response_id = headers.response_id INNER JOIN entries ON entries.entry_id = responses.entry_id WHERE headers.content_type= '$content_type' AND cast(entries.startedDateTime as Time) 
            BETWEEN '$time_1' AND '$time_2' ";

            $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));


            $avg_wait = mysqli_fetch_array($query_run);



            $avg_wait = $avg_wait['avg_wait'];
            $interval = $interval + 2;

            $data[$content_type][$i] = $avg_wait;
        }
        $interval = 0;
    }
    echo json_encode($data);
}

if ($_POST["type"] == 'method_chart') {

    // initiating iterating time array
    $hours = array(
        "00:00:00", "00:59:59", "01:00:00", "01:59:59", "02:00:00", "02:59:59", "03:00:00", "03:59:59", "04:00:00", "04:59:59",
        "05:00:00", "05:59:59", "06:00:00", "06:59:59", "07:00:00", "07:59:59", "08:00:00", "08:59:59", "09:00:00", "09:59:59", "10:00:00", "10:59:59", "11:00:00", "11:59:59", "12:00:00", "12:59:59",
        "13:00:00", "13:59:59", "14:00:00", "14:59:59", "15:00:00", "15:59:59", "16:00:00", "16:59:59", "17:00:00", "17:59:59",
        "18:00:00", "18:59:59", "19:00:00", "19:59:59", "20:00:00", "20:59:59", "21:00:00", "21:59:59", "22:00:00", "22:59:59", "23:00:00", "23:59:59"
    );

    $interval = 0;

    // get all method types
    $query = "SELECT DISTINCT(method) FROM requests";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $method_types = mysqli_fetch_all($query_run);

    $method_type_array = array();

    foreach ($method_types as $row) {
        $method = $row[0];

        // for each method type calculate its average wait per hour of the day
        for ($i = 0; $i < 24; $i++) {

            $time_1 = $hours[$interval];
            $time_2 = $hours[$interval + 1];

            $query = "SELECT AVG(entries.wait) AS avg_wait FROM entries INNER JOIN requests ON requests.entry_id = entries.entry_id WHERE requests.method = '$method' AND cast(entries.startedDateTime as Time) 
            BETWEEN '$time_1' AND '$time_2' ";

            $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

            $avg_wait = mysqli_fetch_array($query_run);

            $avg_wait = $avg_wait['avg_wait'];
            $interval = $interval + 2;

            $data[$method][$i] = $avg_wait;
        }

        $interval = 0;
    }
    echo json_encode($data);
}

if ($_POST["type"] == 'isp_chart') {

    $hours = array(
        "00:00:00", "00:59:59", "01:00:00", "01:59:59", "02:00:00", "02:59:59", "03:00:00", "03:59:59", "04:00:00", "04:59:59",
        "05:00:00", "05:59:59", "06:00:00", "06:59:59", "07:00:00", "07:59:59", "08:00:00", "08:59:59", "09:00:00", "09:59:59", "10:00:00", "10:59:59", "11:00:00", "11:59:59", "12:00:00", "12:59:59",
        "13:00:00", "13:59:59", "14:00:00", "14:59:59", "15:00:00", "15:59:59", "16:00:00", "16:59:59", "17:00:00", "17:59:59",
        "18:00:00", "18:59:59", "19:00:00", "19:59:59", "20:00:00", "20:59:59", "21:00:00", "21:59:59", "22:00:00", "22:59:59", "23:00:00", "23:59:59"
    );
    $interval = 0;

    // get all isps
    $query = "SELECT DISTINCT(upload_isp) FROM files";
    $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $upload_isps = mysqli_fetch_all($query_run);

    $upload_isp_array = array();

    foreach ($upload_isps as $row) {
        $isp = $row[0];

        // for each method type calculate its average wait per hour of the day
        for ($i = 0; $i < 24; $i++) {

            $time_1 = $hours[$interval];
            $time_2 = $hours[$interval + 1];

            $query = "SELECT AVG(entries.wait) AS avg_wait FROM entries RIGHT JOIN files ON files.file_id = entries.file_id WHERE files.upload_isp = '$isp' AND cast(entries.startedDateTime as Time) 
                BETWEEN '$time_1' AND '$time_2' ";

            $query_run = mysqli_query($conn, $query) or die(mysqli_error($conn));

            $avg_wait = mysqli_fetch_array($query_run);

            $avg_wait = $avg_wait['avg_wait'];
            $interval = $interval + 2;

            $data[$isp][$i] = $avg_wait;
        }

        $interval = 0;
    }
    echo json_encode($data);
}
