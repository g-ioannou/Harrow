<?php
session_start();
include '../model/connection_db.php';


//

if ($_POST['type'] == "regs")
{
   
    $query = "SELECT COUNT(user_id) AS user_count FROM users ";
    $query_run = mysqli_query($conn, $query);
    $user_count = mysqli_fetch_array($query_run);
    $user_count = $user_count["user_count"];
    echo $user_count;
}
// session_start();
// include ("../model/connection_db.php");


if ($_POST['type'] == "methods")
{
    
    $query = "SELECT method ,count(*) FROM requestss WHERE method='GET' ";
    $query_run = mysqli_query($conn, $query);
    // $method_count = mysqli_fetch_array($query_run);
    $row = mysqli_fetch_assoc($query_run);
    if($row == 0)
      echo "woj";
      else
foreach($row  as $value){
    //Print the element out.
    echo $value, '<br>';
}


$query = "SELECT method ,count(*) FROM requestss WHERE method='POST' ";
$query_run = mysqli_query($conn, $query);
// $method_count = mysqli_fetch_array($query_run);
$row = mysqli_fetch_assoc($query_run);
if($row == 0)
  echo "woj";
  else
foreach($row  as $value){
//Print the element out.
echo $value, '<br>';
}

    
    // $method_count = mysqli_fetch_array($query_run);
    // $method_count = $method_count["method_count"];
    // echo $method_count;
} 






// $query = "SELECT id FROM user ORDER BY id ";
// $query_run = mysqli_query($conn, $query);
// $row= mysqli_num_rows($query_run);
//  echo $row;
?>