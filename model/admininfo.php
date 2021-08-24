<?php
session_start();
include '../model/connection_db.php';





if ($_POST['type'] == "regs")
{
   
    $query = "SELECT COUNT(user_id) AS user_count FROM users ";
    $query_run = mysqli_query($conn, $query);
    $user_count = mysqli_fetch_array($query_run);
    $user_count = $user_count["user_count"];
    echo $user_count;
}



if ($_POST['type'] == "methods")
{
    
    $query = "SELECT method ,count(*) FROM requests WHERE method='GET' ";
    $query_run = mysqli_query($conn, $query);
  
    $row = mysqli_fetch_assoc($query_run);
   
foreach($row  as $value){
    //Print the element out.
    echo $value, '<br>';
}


$query = "SELECT method ,count(*) FROM requests WHERE method='POST' ";
$query_run = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($query_run);

foreach($row  as $value){
//Print the element out.
echo $value, '<br>';
}



} 



if ($_POST['type'] == "status")
{
    
    $query = "SELECT status ,count(*) FROM responses WHERE status='200' ";
    $query_run = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($query_run);
  
foreach($row  as $value){
    //Print the element out.
    if($value==0)
  break;
  else
    echo  $value, "\r\n" ;
    
}


$query = "SELECT status ,count(*) FROM responses WHERE status='404' ";
$query_run = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($query_run);

foreach($row  as $value){
//Print the element out.
if($value==0)
  break;
  else
  // echo "<br";
echo $value,  "\r\n";
}

$query = "SELECT status ,count(*) FROM responses WHERE status='401' ";
$query_run = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($query_run);

foreach($row  as $value){
//Print the element out.
if($value==0)
  break;
  else

echo $value,  "\r\n";
}



$query = "SELECT status ,count(*) FROM responses WHERE status='403' ";
$query_run = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($query_run);

foreach($row  as $value){
//Print the element out.
if($value==0)
  break;
  else
  // echo "<br";

echo $value, "\r\n";
}


$query = "SELECT status ,count(*) FROM responses WHERE status='304' ";
$query_run = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($query_run);
foreach($row  as $value){
//Print the element out.
if($value==0)
  break;
  else
  // echo "<br";
echo $value, "\r\n" ;
}

$query = "SELECT status ,count(*) FROM responses WHERE status='500' ";
$query_run = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($query_run);
foreach($row  as $value){
//Print the element out.
if($value==0)
  break;
  else
  // echo "<br";
echo $value,  "\r\n";
}



} 

if ($_POST['type'] == "domain")
{
   
    $query = "SELECT COUNT(DISTINCT url ) AS domain_count FROM requests;";
    $query_run = mysqli_query($conn, $query);
    $domain_count = mysqli_fetch_array($query_run);
    $domain_count = $domain_count["domain_count"];
    echo $domain_count;
}

if ($_POST['type'] == "isps")
{
   
    $query = "SELECT COUNT(DISTINCT upload_isp ) AS isp_count FROM files;";
    $query_run = mysqli_query($conn, $query);
    $isp_count = mysqli_fetch_array($query_run);
    $isp_count = $isp_count["isp_count"];
    echo $isp_count;
}




?>