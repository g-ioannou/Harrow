<?php
session_start();
include "../model/connection_db.php";

if ($_POST['type'] == "content_type_histogram"){
    $data_array = $_POST['data_array'];

    $data = new stdClass();
    $min = INF;
    $max = -1;    
    foreach ($data_array as $content_type) {

        
        
        $sql = mysqli_query($conn, "SELECT content_type,SUBSTRING_INDEX(SUBSTRING_INDEX(cache_control,'max_age=',-1), ',', 1 ) AS ttl FROM headers 
                                      WHERE response_id IS NOT NULL AND cache_control IS NOT NULL AND cache_control LIKE '%max_age%' AND cache_control NOT LIKE '%max_age=0%' 
                                      AND  content_type = '$content_type'
                                      UNION ALL
                                      (SELECT content_type,STR_TO_DATE((SUBSTRING_INDEX(SUBSTRING_INDEX(last_modified, ', ' , -1), ' GMT',1)), '%d %b %Y %H:%i:%s') - STR_TO_DATE((SUBSTRING_INDEX(SUBSTRING_INDEX(expires, ', ' , -1), ' GMT',1)), '%d %b %Y %H:%i:%s') 
                                      AS ttl FROM headers 
                                      WHERE expires IS NOT NULL
                                      AND last_modified IS NOT NULL
                                      AND content_type= '$content_type'
                                      AND pragma = 'no_cache'
                                      AND content_type IS NOT NULL)
                                      ORDER BY content_type  ") or die(mysqli_error($conn));
        $results = mysqli_fetch_all($sql);
        
        if(mysqli_num_rows($sql) != 0){
            $data->$content_type = $results;
            
        }


        
    }
    echo json_encode($data);
    
    

}











?>