<?php
session_start();

include "../model/connection_db.php";

$user_id = $_SESSION['user_id'];
$upload_ip = $_SESSION['ip'];
$file_name = $_POST['name'];
$file_size = $_POST['size'];
$upload_isp = $_SESSION['isp'];
$upload_location = $_SESSION['city'];
$text_contents = $_POST['contents'];

$query = mysqli_query($conn, "CALL add_file('$user_id','$file_name','$file_size','$upload_isp','$upload_location','$text_contents','$upload_ip')") or die(mysqli_error($conn));

$result = mysqli_fetch_array($query);

$file_id =  $result['file_id'];


$query->close();
$conn->next_result();

$json_contents = json_decode($text_contents);
$entries = $json_contents->contents;


foreach ($entries as $entry) {

    $_startedDateTime = checkIfKeyExists('startedDateTime',$entry,0);
    
    $_serverIpAddress = checkIfKeyExists('serverIPAddress',$entry,1);
    ;
    
    $_wait = checkIfKeyExists('wait', $entry->timings,0);
    $_wait = number_format($_wait, 5);
    echo $_wait;

    // ------------------ ADD ENTRY ----------------
    $sql = mysqli_query($conn, "CALL add_entry('$file_id','$_startedDateTime',$_serverIpAddress,$_wait)") or die(mysqli_error($conn));

    $res = mysqli_fetch_array($sql);
    $entry_id = $res['entry_id'];

    $sql->close();
    $conn->next_result();

    
    // ----------------ADD ENTRY'S REQUEST ---------

    $_method = $entry->request->method;
    $_url = $entry->request->url;

    $sql = mysqli_query($conn, "CALL add_request('$entry_id','$_method','$_url')") or die(mysqli_error(($conn)));

    $res = mysqli_fetch_array($sql);
    $request_id = $res['request_id'];

    $sql->close();
    $conn->next_result();
    $column_name = "request_id";


    
    $headers = $entry->request->headers;
    
    add_headers($conn, $column_name, $request_id, $headers);
    
    // ----------------ADD ENTRY'S RESPONSE ---------

    $_status = $entry->response->status;
    $_statusText = $entry->response->statusText;


    $_statusText = checkIfKeyExists('statusText',$entry->response,1);
    if ($_status == 0) {
        $_status = "NULL";
    }

    
    $sql = mysqli_query($conn, "CALL add_response($entry_id,$_status,$_statusText)") or die(mysqli_error($conn));

    $res = mysqli_fetch_array($sql);
    $response_id = $res['response_id'];

    $sql->close();
    $conn->next_result();

    $column_name = "response_id";
    $headers = $entry->response->headers;
   
    add_headers($conn, $column_name, $response_id, $headers);
}

function add_headers($conn, $type, $r_id, $headers)
{
    $all_null = 0;
    foreach ($headers as $header) {
        
        $_content_type = checkIfKeyExists('content-type', $header,1);
        
        $_cache_control = checkIfKeyExists('cache-control', $header,1);
        $_pragma = checkIfKeyExists('pragma', $header,1);
        $_expires = checkIfKeyExists("expires", $header,1);
        $_age = checkIfKeyExists('age', $header,0);
        $_last_modified = checkIfKeyExists('last-modified', $header,1);
        $_host = checkIfKeyExists('host', $header,1);

        if($_content_type=="NULL" and $_cache_control=="NULL" and $_pragma=="NULL" and $_expires=="NULL" and $_age=="NULL" and $_last_modified=="NULL" and $_host=="NULL"){
            $all_null =1 ;
        }

        if ($all_null == 0) {
            $sql = mysqli_query($conn, "INSERT INTO headers ($type,content_type,pragma,expires,age,last_modified,host,cache_control) VALUES ($r_id,$_content_type,$_pragma,$_expires,$_age,$_last_modified, $_host, $_cache_control)") or die(mysqli_error($conn));
        }
    }
}

function checkIfKeyExists($key,$obj,$str){
    if (isset($obj->$key) and $obj->$key!='') {
        $_key = $obj->$key;
        if($str==1){
            $_key = "'$_key'";
         
        }
    }
    else {
        $_key = "NULL";
    }

    

    return $_key;
}
?>