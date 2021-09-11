<?php
session_start();
include "../model/connection_db.php";

if ($_POST['type'] == "content_type_histogram") {
    $data_array = $_POST['data_array'];

    $data = new stdClass();

    $min = INF;
    $max = -1;

    $data->ttl_data = new stdClass();
    $data->cacheability_data = new stdClass();

    foreach ($data_array as $content_type) {

        /**
         * 
         *      TTL data for histogram
         * 
         */

        $sql = mysqli_query($conn, "SELECT content_type, CONVERT(SUBSTRING_INDEX(REGEXP_SUBSTR(cache_control, 'max(_|-)age=[0-9\-]+'), '=', -1), UNSIGNED INTEGER) AS ttl FROM `headers` WHERE content_type IS NOT NULL AND cache_control LIKE '%max%' AND content_type='$content_type'
                                      UNION ALL
                                      (SELECT content_type,STR_TO_DATE((SUBSTRING_INDEX(SUBSTRING_INDEX(last_modified, ', ' , -1), ' GMT',1)), '%d %b %Y %H:%i:%s') - STR_TO_DATE((SUBSTRING_INDEX(SUBSTRING_INDEX(expires, ', ' , -1), ' GMT',1)), '%d %b %Y %H:%i:%s') 
                                      AS ttl FROM headers 
                                      WHERE expires  IS NOT NULL
                                      AND last_modified IS NOT NULL
                                      AND pragma = 'no_cache'
                                      AND content_type  IS NOT NULL
                                      AND content_type='$content_type'
                                      AND STR_TO_DATE((SUBSTRING_INDEX(SUBSTRING_INDEX(last_modified, ', ' , -1), ' GMT',1)), '%d %b %Y %H:%i:%s') - STR_TO_DATE((SUBSTRING_INDEX(SUBSTRING_INDEX(expires, ', ' , -1), ' GMT',1)), '%d %b %Y %H:%i:%s')>0)
                                      ORDER BY ttl  ") or die(mysqli_error($conn));

        $results = mysqli_fetch_all($sql);

        if (mysqli_num_rows($sql) != 0) {
            $data->ttl_data->$content_type = $results;

            $temp_min = (int)$data->ttl_data->$content_type[0][1];

            $temp_max = (int)end($data->ttl_data->$content_type)[1];
            if ($temp_min < $min) {
                $min = $temp_min;
            }
            if ($temp_max > $max) {
                $max = $temp_max;
            }
        }
        // SELECT *, COUNT(*) AS count FROM (SELECT content_type , REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') AS cacheability FROM headers WHERE REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') IS NOT NULL AND REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') NOT LIKE '' AND content_type IS NOT NULL) AS t1 INNER JOIN (SELECT COUNT(*) AS total_count FROM headers WHERE REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') IS NOT NULL AND REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') NOT LIKE '' AND content_type IS NOT NULL ) AS t2 ON 1 GROUP BY t1.content_type,t1.cacheability;
        $results = mysqli_fetch_array($sql);
    }
    $data->ttl_data->min = $min;
    $data->ttl_data->max = $max;

    /**
     * 
     *       CACHEABILITY data for pie
     * 
     */
    $sql = mysqli_query($conn, "SELECT *, COUNT(*) AS count , COUNT(*)/t2.total_count*100 
                                FROM 
                                    (SELECT content_type , REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') AS cacheability 
                                        FROM headers 
                                        WHERE REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') IS NOT NULL 
                                        AND REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') NOT LIKE '' 
                                        AND content_type IS NOT NULL) AS t1 
                                INNER JOIN 
                                    (SELECT COUNT(*) AS total_count FROM headers 
                                        WHERE REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') IS NOT NULL 
                                        AND REGEXP_SUBSTR(cache_control,'private|public|no(_|-)cache|no(-|_)store') NOT LIKE '' 
                                        AND content_type IS NOT NULL ) AS t2 ON 1 
                                GROUP BY t1.content_type,t1.cacheability;") or die(mysqli_error($conn));

    $results = mysqli_fetch_all($sql);
    
    foreach ($results as $row) {
        $name = "$row[0]+$row[1]";
        

        
        $data->cacheability_data->$name = $row;
    }

    echo json_encode($data);
}
