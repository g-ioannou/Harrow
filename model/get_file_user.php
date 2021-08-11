<?
session_start();
include "../model/connection_db.php";
$user_id = $_SESSION['user_id'];

$sql = mysqli_query($conn, "CALL get_files('$user_id')") or die(mysqli_error($conn));

$file = array();
while ($row = mysqli_fetch_array($sql)) {
    $file_name = $row['name'];
    $file_size = $row['size'];
    $file_isp = $row['upload_isp'];
    $file_location = $row['upload_location'];
    $file_contents = $row['full_file'];
    $file_up_date = $row['upload_date'];
    $file_db_id = $row['file_id'];

    $file[] = array("name" => $file_name, "size" => $file_size, "isp" => $file_isp, "upload_loc" => $file_location, "contents" => $file_contents, "upload_date" => $file_up_date, 'db_id' => $file_db_id);
}


echo json_encode($file);

$sql->close();
$conn->next_result();
