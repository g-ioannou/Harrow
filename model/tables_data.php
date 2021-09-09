<?php
session_start();
include "../model/connection_db.php";

if ($_POST['type'] == "content_type_histogram"){
    $data_array = $_POST['data_array'];

    $data = new stdClass();
    
    foreach ($data_array as $content_type) {
        
        $sql = mysqli_query($conn, "SELECT content_type,SUBSTRING_INDEX(SUBSTRING_INDEX(cache_control,'max_age=',-1), ',', 1 ) AS max_age FROM headers 
                                WHERE response_id IS NOT NULL AND cache_control IS NOT NULL AND cache_control LIKE '%max_age%' AND cache_control NOT LIKE '%max_age=0%' AND  content_type = '$content_type' 
                                ORDER BY content_type") or die(mysqli_error($conn));
        $results = mysqli_fetch_all($sql);
        
        if(mysqli_num_rows($sql) != 0){
            $data->$content_type = $results;
        }
        
    }
    echo json_encode($data);
    
    

}











?>