<?php
session_start();

include "../model/connection_db.php";

$user_id = $_SESSION['user_id'];
$file_name = $_POST['name'];
$file_size = $_POST['size'];
$upload_isp = $_SESSION['isp'];
$upload_location = $_SESSION['city'];
$text_contents = $_POST['contents'];


$query = mysqli_query($conn, "CALL add_file('$user_id','$file_name','$file_size','$upload_isp','$upload_location','$text_contents')") or die(mysqli_error($conn));

$result = mysqli_fetch_array($query);

$file_id =  $result['file_id'];

$query->close();
$conn->next_result();

$json_contents = json_decode($text_contents);
$entries = $json_contents->contents;

foreach ($entries as $entry) {
    if (array_key_exists('startedDateTime', $entry)) {
        $_startedDateTime = "$entry->startedDateTime";
    } else {
        $_startedDateTime = "NULL";
    }

    if (array_key_exists('serverIpAddress', $entry)) {
        $_serverIpAddress = "$entry->serverIpAddress";
    } else {
        $_serverIpAddress = "NULL";
    }

    if (array_key_exists('wait', $entry)) {
        $_wait = $entry->wait;
    } else {
        $_wait = "NULL";
    }

    // ------------===--- ADD ENTRY ----------------
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


    if ($_statusText == "") {
        $_statusText = "Invalid response";
    }
    if ($_status == 0) {
        $_status = "NULL";
    }


    $sql = mysqli_query($conn, "CALL add_response('$entry_id',$_status,'$_statusText')") or die(mysqli_error($conn));

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
    foreach ($headers as $header) {
        if (array_key_exists('content_type', $header)) {
            $_content_type = "'$header->content_type'";
            $all_null = 0;
        } else {
            $_content_type = "NULL";
        }

        if (array_key_exists('cache_control', $header)) {
            $_cache_control = "'$header->cache_control'";
            $all_null = 0;
        } else {
            $_cache_control = "NULL";
        }

        if (array_key_exists('pragma', $header)) {
            $_pragma = "'$header->pragma'";
            $all_null = 0;
        } else {
            $_pragma = "NULL";
        }

        if (array_key_exists('expires', $header)) {
            $_expires = "'$header->expires'";
            $all_null = 0;
        } else {
            $_expires = "NULL";
        }

        if (array_key_exists('age', $header)) {
            $_age = $header->age;
            $all_null = 0;
        } else {
            $_age = "NULL";
        }

        if (array_key_exists('last_modified', $header)) {
            $_last_modified = "'$header->last_modified'";
            $all_null = 0;
        } else {
            $_last_modified = "NULL";
        }


        if (array_key_exists('host', $header)) {
            $_host = "'$header->host'";
            $all_null = 0;
        } else {
            $_host = "NULL";
        }

        if ($all_null == 0) {
            continue;
        }

        $sql = mysqli_query($conn, "INSERT INTO headers ($type,content_type,pragma,expires,age,last_modified,host,cache_control) VALUES ($r_id,$_content_type,$_pragma,$_expires,$_age,$_last_modified, $_host, $_cache_control)") or die(mysqli_error($conn));
    }
}
