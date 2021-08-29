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

    $_startedDateTime = checkIfKeyExists('startedDateTime', $entry);

    if ($_startedDateTime != "NULL") {
        $_startedDateTime = "'" . $_startedDateTime . "'";
    }

    $_serverIpAddress = checkIfKeyExists('serverIPAddress', $entry);

    if ($_serverIpAddress != "NULL") {
        $_serverIpAddress = "'" . $_serverIpAddress . "'";
    }

    $_wait = checkIfKeyExists('wait', $entry->timings);
    $_wait = number_format($_wait, 5, '.', ''); // '.'= decimal seperator , ','=thousands seperator

    // ------------------ ADD ENTRY ----------------
    $sql = mysqli_query($conn, "CALL add_entry('$file_id',$_startedDateTime,$_serverIpAddress,$_wait)") or die(mysqli_error($conn));

    $res = mysqli_fetch_array($sql);
    $entry_id = $res['entry_id'];

    $sql->close();
    $conn->next_result();


    // ----------------ADD ENTRY'S REQUEST ---------

    $_method = $entry->request->method;
    $_url = $entry->request->url;

    if ($_method != "NULL") {
        $_method = "'" . $_method . "'";
    }

    if ($url != "NULL") {
        $_url = "'" . $_url . "'";
    }

    $sql = mysqli_query($conn, "CALL add_request('$entry_id',$_method,$_url)") or die(mysqli_error(($conn)));

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


    $_statusText = checkIfKeyExists('statusText', $entry->response);

    if ($_statusText != 'NULL') {
        $_statusText = "'" . $_statusText . "'";
    }

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
    $all_null = 1;

    $headers_obj = new stdClass();

    $headers_obj->{"cache-control"} = "NULL";
    $headers_obj->{"content-type"} = "NULL";
    $headers_obj->pragma = "NULL";
    $headers_obj->expires = "NULL";
    $headers_obj->age = "NULL";
    $headers_obj->{"last-modified"} = "NULL";
    $headers_obj->host = "NULL";



    foreach ($headers as $header) {
        // although every header has one value its easier to iterate it with the loop

        $header_name = get_object_vars($header);
        $header_name =  array_keys($header_name)[0];

        if (is_string($header->$header_name)) {
            $headers_obj->{$header_name} = "'" . $header->$header_name . "'";
        } else {
            $headers_obj->{$header_name} = $header->$header_name;
        }


        $all_null = 0;
    }

    $_cache_control = $headers_obj->{"cache-control"};
    $_content_type = $headers_obj->{"content-type"};
    $_pragma = $headers_obj->pragma;
    $_expires = $headers_obj->expires;
    $_age = $headers_obj->age;
    $_last_modified = $headers_obj->{"last-modified"};
    $_host = $headers_obj->host;



    if ($all_null == 0) {
        $sql = mysqli_query($conn, "INSERT INTO headers ($type,cache_control,pragma,expires,age,last_modified,host,content_type) VALUES ($r_id,$_cache_control,$_pragma,$_expires,$_age,$_last_modified, $_host, $_content_type)") or die(mysqli_error($conn));
    }
}

function checkIfKeyExists($key, $obj)
{
    if (isset($obj->{$key}) and $obj->{$key} != '') {
        $_key = $obj->{$key};
    } else {
        $_key = "NULL";
    }



    return $_key;
}
