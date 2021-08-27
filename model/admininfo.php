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
    
    $query = "SELECT method ,count(*) AS get_count FROM requests WHERE method='GET' ";
    $query_run = mysqli_query($conn, $query);
   $get_count = mysqli_fetch_array($query_run);
  $get_count = $get_count["get_count"];
   

    echo"GET:", $get_count, '<br>';

$query = "SELECT method ,count(*) AS post_count FROM requests WHERE method='POST' ";
$query_run = mysqli_query($conn, $query);
$post_count = mysqli_fetch_array($query_run);
$post_count = $post_count["post_count"];
 

//Print the element out.
echo "POST:", $post_count, '<br>';




} 



if ($_POST['type'] == "status")
{
    
    $query = "SELECT status ,count(*) AS status1_count FROM responses WHERE status='200' ";
    $query_run = mysqli_query($conn, $query);
    $status1_count = mysqli_fetch_array($query_run);
    $status1_count = $status1_count["status1_count"];
    // if($status1_count==0)
    // break;
    // else
    echo "200:",  $status1_count, "\r\n" ;
    



$query = "SELECT status ,count(*)AS status2_count FROM responses WHERE status='404' ";
$query_run = mysqli_query($conn, $query);
$status2_count = mysqli_fetch_array($query_run);
$status2_count = $status2_count["status2_count"];
// if($status2_count==0)
// break;
// else
echo "404:",  $status2_count, "\r\n" ;


$query = "SELECT status ,count(*)AS status3_count FROM responses WHERE status='401' ";
$query_run = mysqli_query($conn, $query);
$status3_count = mysqli_fetch_array($query_run);
$status3_count = $status3_count["status3_count"];
// if($status3_count==0)
// break;
// else
echo "401:",  $status3_count, "\r\n" ;




$query = "SELECT status ,count(*)AS status4_count FROM responses WHERE status='403' ";
$query_run = mysqli_query($conn, $query);
$status4_count = mysqli_fetch_array($query_run);
$status4_count = $status4_count["status4_count"];
// if($status4_count==0)
// break;
// else
echo "403:",  $status4_count, "\r\n" ;



$query = "SELECT status ,count(*) AS status5_count FROM responses WHERE status='304' ";
$query_run = mysqli_query($conn, $query);
$status5_count = mysqli_fetch_array($query_run);
$status5_count = $status5_count["status5_count"];
// if($status5_count==0)
// break;
// else
echo "304:",  $status5_count, "\r\n" ;


$query = "SELECT status ,count(*)AS status6_count FROM responses WHERE status='500' ";
$query_run = mysqli_query($conn, $query);
$status6_count = mysqli_fetch_array($query_run);
$status6_count = $status6_count["status6_count"];
// if($status6_count==0)
// break;
// else
echo "500:",  $status6_count, "\r\n" ;

}



 

if ($_POST['type'] == "domain")
{
   
    $query = "SELECT COUNT(DISTINCT url ) AS domain_count FROM requests";
    $query_run = mysqli_query($conn, $query);
    $domain_count = mysqli_fetch_array($query_run);
    $domain_count = $domain_count["domain_count"];
    echo $domain_count;
}

if ($_POST['type'] == "isps")
{
   
    $query = "SELECT COUNT(DISTINCT upload_isp ) AS isp_count FROM files";
    $query_run = mysqli_query($conn, $query);
    $isp_count = mysqli_fetch_array($query_run);
    $isp_count = $isp_count["isp_count"];
    echo $isp_count;
}
if ($_POST['type'] == "isp")
{
   
    $query = "SELECT COUNT(DISTINCT upload_isp ) AS isp_count FROM files";
    $query_run = mysqli_query($conn, $query);
    $isp_count = mysqli_fetch_array($query_run);
    $isp_count = $isp_count["isp_count"];
    echo $isp_count;
}
if ($_POST['type'] == "average")
{
   
    $query = "SELECT DISTINCT content_type  AS content_type FROM headers WHERE content_type IS NOT NULL";
    $query_run = mysqli_query($conn, $query);
    $cont=[];
    while($content_type = mysqli_fetch_array($query_run))
       {
         $cont[]=$content_type['content_type'];
       }
  
    foreach($cont as &$value)
    {
  
  

      $query = "SELECT AVG(age) AS avrg FROM headers WHERE content_type ='$value'";
      $query_run = mysqli_query($conn, $query);
      if (!$query_run)
       {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
      $avrg = mysqli_fetch_array($query_run);
      $avrg=$avrg["avrg"];
      echo $value, ":", $avrg;
      echo "\n";
     
    }

}

// if ($_POST['type']=="data")
// {
//   $query= "SELECT"
// }

?>