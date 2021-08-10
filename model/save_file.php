<?

use function PHPSTORM_META\type;

session_start();
include "../model/connection_db.php";
if (!isset($_SESSION['email'])) {
    header('Location: ../view/home_user/home.php');
}

$user_id = $_SESSION['user_id'];
$file_name = $_POST['name'];
$file_size = $_POST['size'];
$upload_isp = $_SESSION['isp'];
$upload_location = $_SESSION['city'];
$text_contents = $_POST['contents'];

$query = mysqli_query($conn, "INSERT INTO files(user_id,name,size,upload_isp,upload_location,full_file) VALUES('$user_id','$file_name','$file_size','$upload_isp','$upload_location','$text_contents')") or die(mysqli_error($conn));

$query = mysqli_query($conn, "SELECT MAX(file_id) AS file_id FROM files WHERE user_id = $user_id");

$res = mysqli_fetch_array($query);
$file_id = $res['file_id'];


$json_contents = json_decode($text_contents);
$entries = $json_contents->contents;

foreach ($entries as $entry) {

    if (array_key_exists('startedDateTime', $entry)) {
        $_startedDateTime = $entry->startedDateTime;
    } else {
        $_startedDateTime = "0000-00-00 00:00:00";
    }

    if (array_key_exists('serverIpAddress', $entry)) {
        $_serverIpAddress = $entry->serverIpAddress;
    } else {
        $_serverIpAddress = 0;
    }

    if (array_key_exists('wait', $entry)) {
        $_wait = $entry->wait;
    } else {
        $_wait = 0;
    }

    $sql = mysqli_query($conn, "INSERT INTO entries(file_id,startedDateTime,serverIpAddress,wait) VALUES ('$file_id','$_startedDateTime','$_serverIpAddress','$_wait')") or die(mysqli_error($conn));

    $sql = mysqli_query($conn, "SELECT MAX(entry_id) AS entry_id FROM entries WHERE file_id = $file_id");


    $res = mysqli_fetch_array($sql);

    $entry_id = $res['entry_id'];

    $_method = $entry->request->method;
    $_url = $entry->request->url;

    $sql = mysqli_query($conn, "INSERT INTO requests(entry_id,method,url) VALUES ('$entry_id','$_method','$_url')") or die(mysqli_error($conn));


    $sql = mysqli_query($conn, "SELECT MAX(request_id) AS request_id FROM requests WHERE entry_id=$entry_id");

    $res = mysqli_fetch_array($sql);

    $request_id = $res['request_id'];

    $headers = $entry->request->headers;

    $type = 'request_id';

    add_headers($conn, $type, $request_id, $headers);

    $_status = $entry->response->status;
    $_statusText = $entry->response->statusText;

    

    $sql = mysqli_query($conn, "INSERT INTO responses(entry_id,status,statusText) VALUES ($entry_id,'$_status','$_statusText')") or die(mysqli_error($conn));

    $sql = mysqli_query($conn, "SELECT MAX(response_id) AS response_id FROM responses WHERE entry_id = $entry_id") or die(mysqli_error($conn));

    $res = mysqli_fetch_array($sql);

    $response_id = $res['response_id'];

    $headers = $entry->response->headers;

    $type = "response_id";

    add_headers($conn, $type, $response_id, $headers);
}


function add_headers($conn, $type, $r_id, $headers)
{
    foreach ($headers as $header) {
        if (array_key_exists('content_type', $header)) {
            $_content_type = $header->content_type;
        } else {
            $_content_type = "NULL";
        }

        if (array_key_exists('cache_control', $header)) {
            $_cache_control = $header->cache_control;
        } else {
            $_cache_control = "NULL";
        }

        if (array_key_exists('pragma', $header)) {
            $_pragma = $header->pragma;
        } else {
            $_pragma = "NULL";
        }

        if (array_key_exists('expires', $header)) {
            $_expires = $header->expires;
        } else {
            $_expires = "NULL";
        }

        if (array_key_exists('age', $header)) {
            $_age = $header->age;
        } else {
            $_age = "NULL";
        }

        if (array_key_exists('last_modified', $header)) {
            $_last_modified = $header->last_modified;
        } else {
            $_last_modified = "NULL";
        }


        if (array_key_exists('host', $header)) {

            $_host = $header->host;
        } else {
            $_host = "NULL";
        }
        
        $sql = mysqli_query($conn, "INSERT INTO headers($type,content_type,pragma,expires,age,last_modified,host,cache_control) VALUES ($r_id,'$_content_type','$_pragma',$_expires,$_age,'$_last_modified', '$_host', '$_cache_control')") or die(mysqli_error($conn));
    }
}
