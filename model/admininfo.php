<?php
session_start();
include '../model/connection_db.php';



if ($_POST['type']=='initial_choices_isp')
{
    $query="SELECT DISTINCT(upload_isp) AS upload_isp FROM files";
    $query_run=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $upload_isp=mysqli_fetch_all($query_run);
    
    echo json_encode($upload_isp);
    
}

    
if ($_POST['type']=='initial_choices_content_type'){
    $query = mysqli_query($conn , "SELECT DISTINCT(content_type) FROM headers WHERE content_type IS NOT NULL") or die(mysqli_error());

    $result = mysqli_fetch_all($query);
    
    echo json_encode($result);
}




if ($_POST['type'] == "initial_choices_method"){
    $query = mysqli_query($conn , "SELECT DISTINCT(method) FROM requests WHERE method IS NOT NULL") or die(mysqli_error());
    $result = mysqli_fetch_all($query);
    
    echo json_encode($result);
}


if ($_POST['type'] == "content_types"){
    $times =array("00:00:00","00:59:59","01:00:00","01:59:59","02:00:00","02:59:59","03:00:00","03:59:59","04:00:00","04:59:59",
    "05:00:00","05:59:59","06:00:00","06:59:59","07:00:00","07:59:59","08:00:00","08:59:59"
    ,"09:00:00","09:59:59","10:00:00","10:59:59","11:00:00","11:59:59","12:00:00","12:59:59",
    "13:00:00","13:59:59","14:00:00","14:59:59","15:00:00","15:59:59","16:00:00","16:59:59","17:00:00","17:59:59",
    "18:00:00","18:59:59","19:00:00","19:59:59","20:00:00","20:59:59","21:00:00","21:59:59","22:00:00","22:59:59","23:00:00","23:59:59");
     
    $time_index = 0;

    $content_list = $_POST['content_list'];
    
    for(i=0; i<24;i++){
        $time_1=$times[$time_index];
        $time_2=$times[$time_index+1];

        foreach ($content_list as $content_type) {
            $querry = mysqli_query($conn, "SELECT AVG(entries.wait) FROM `headers` RIGHT JOIN responses ON responses.response_id =headers.response_id INNER JOIN entries ON entries.entry_id = responses.entry_id WHERE headers.content_type= '$content_type' AND cast(entries.startedDateTime as Time) 
            BETWEEN '$time_1' AND '$time_2' ");
        }
    $content_type_data = mysqli_fetch_array($query);
   
    $avg_wait=$avg_wait['avg_wait'];
     $time_index=$time_index+2;    
     $data[$i]=$avg_wait;
    }
    
    
}



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
      if($avrg==NULL){
      echo "<b>", $value ,"</b>", " : 0";
      echo "\n";}
      else{
      echo "<b>",$value, "</b>", " : ", $avrg;
      echo "\n";
      }
    }

}
if($_POST["type"]=='Avg_Wait_Chart')
{ 
    
    $k=array("00:00:00","00:59:59","01:00:00","01:59:59","02:00:00","02:59:59","03:00:00","03:59:59","04:00:00","04:59:59",
    "05:00:00","05:59:59","06:00:00","06:59:59","07:00:00","07:59:59","08:00:00","08:59:59"
    ,"09:00:00","09:59:59","10:00:00","10:59:59","11:00:00","11:59:59","12:00:00","12:59:59",
    "13:00:00","13:59:59","14:00:00","14:59:59","15:00:00","15:59:59","16:00:00","16:59:59","17:00:00","17:59:59",
    "18:00:00","18:59:59","19:00:00","19:59:59","20:00:00","20:59:59","21:00:00","21:59:59","22:00:00","22:59:59","23:00:00","23:59:59");
     $z=0;
    
    for($i=0;$i<24;$i++)
   { 
       $time_1=$k[$z];
       $time_2=$k[$z+1];

    $query = "SELECT  AVG(wait) AS avg_wait FROM entries WHERE cast(startedDateTime as Time) BETWEEN '$time_1' AND '$time_2'  ";
    
    $query_run = mysqli_query($conn, $query);
    if (!$query_run)
    {
     printf("Error: %s\n", mysqli_error($conn));
     exit();
    }
    $avg_wait= mysqli_fetch_array($query_run);
   
    $avg_wait=$avg_wait['avg_wait'];
     $z=$z+2;
     $data[$i]=$avg_wait;
   }
  

        echo json_encode($data);


        
       
}
// if($_POST["type"]=='Content_Type_Chart')
// { 
    
//     $k=array("00:00:00","00:59:59","01:00:00","01:59:59","02:00:00","02:59:59","03:00:00","03:59:59","04:00:00","04:59:59",
//     "05:00:00","05:59:59","06:00:00","06:59:59","07:00:00","07:59:59","08:00:00","08:59:59"
//     ,"09:00:00","09:59:59","10:00:00","10:59:59","11:00:00","11:59:59","12:00:00","12:59:59",
//     "13:00:00","13:59:59","14:00:00","14:59:59","15:00:00","15:59:59","16:00:00","16:59:59","17:00:00","17:59:59",
//     "18:00:00","18:59:59","19:00:00","19:59:59","20:00:00","20:59:59","21:00:00","21:59:59","22:00:00","22:59:59","23:00:00","23:59:59");
//      $z=0;
//      $content_type_array=array();

//      $query="SELECT DISTINCT content_type AS cnt_type FROM headers ";
//      $query_run= mysqli_query($conn,$query);
//      if (!$query_run)
//     {
//      printf("Error: %s\n", mysqli_error($conn));
//      exit();
//     }
//     $cnt_type= mysqli_fetch_array($query_run);
//     $cnt_type=$cnt_type['cnt_type']; 
    
//     foreach($cnt_type as $row)
//     {
//       $content_type_array=$row);
//     } 

//     for($i=0;$i<count($content_type_array);$i++)
//    { 
//     $content_type_array1=$content_type_array[i];
//        $time_1=$k[$z];
//        $time_2=$k[$z+1];


//     $query = "SELECT AVG(entries.wait) FROM `headers` RIGHT JOIN responses ON responses.response_id =headers.response_id INNER JOIN entries ON entries.entry_id = responses.entry_id WHERE headers.content_type= '$content_type_array1' AND cast(entries.startedDateTime as Time) 
//     BETWEEN '$time_1' AND '$time_2' ";
    
//     $query_run = mysqli_query($conn, $query);
//     if (!$query_run)
//     {
//      printf("Error: %s\n", mysqli_error($conn));
//      exit();
//     }
//     $avg_wait= mysqli_fetch_array($query_run);
   
//     $avg_wait=$avg_wait['avg_wait'];
//      $z=$z+2;
//      $data[$i]=$avg_wait;
//    }
  

//         echo json_encode($data);


// }

// if($_POST["type"]=='Method_Chart')
// { 
    
//     $k=array("00:00:00","00:59:59","01:00:00","01:59:59","02:00:00","02:59:59","03:00:00","03:59:59","04:00:00","04:59:59",
//     "05:00:00","05:59:59","06:00:00","06:59:59","07:00:00","07:59:59","08:00:00","08:59:59"
//     ,"09:00:00","09:59:59","10:00:00","10:59:59","11:00:00","11:59:59","12:00:00","12:59:59",
//     "13:00:00","13:59:59","14:00:00","14:59:59","15:00:00","15:59:59","16:00:00","16:59:59","17:00:00","17:59:59",
//     "18:00:00","18:59:59","19:00:00","19:59:59","20:00:00","20:59:59","21:00:00","21:59:59","22:00:00","22:59:59","23:00:00","23:59:59");
//      $z=0;
    
//     for($i=0;$i<24;$i++)
//    { 
//        $time_1=$k[$z];
//        $time_2=$k[$z+1];

//     $query = "SELECT  AVG(wait) AS avg_wait FROM entries WHERE cast(startedDateTime as Time) BETWEEN '$time_1' AND '$time_2'  ";
    
//     $query_run = mysqli_query($conn, $query);
//     if (!$query_run)
//     {
//      printf("Error: %s\n", mysqli_error($conn));
//      exit();
//     }
//     $avg_wait= mysqli_fetch_array($query_run);
   
//     $avg_wait=$avg_wait['avg_wait'];
//      $z=$z+2;
//      $data[$i]=$avg_wait;
//    }
  

//         echo json_encode($data);


        
       
// }
// if($_POST["type"]=='ISP_Chart')
// { 
    
//     $k=array("00:00:00","00:59:59","01:00:00","01:59:59","02:00:00","02:59:59","03:00:00","03:59:59","04:00:00","04:59:59",
//     "05:00:00","05:59:59","06:00:00","06:59:59","07:00:00","07:59:59","08:00:00","08:59:59"
//     ,"09:00:00","09:59:59","10:00:00","10:59:59","11:00:00","11:59:59","12:00:00","12:59:59",
//     "13:00:00","13:59:59","14:00:00","14:59:59","15:00:00","15:59:59","16:00:00","16:59:59","17:00:00","17:59:59",
//     "18:00:00","18:59:59","19:00:00","19:59:59","20:00:00","20:59:59","21:00:00","21:59:59","22:00:00","22:59:59","23:00:00","23:59:59");
//      $z=0;

    
//     for($i=0;$i<24;$i++)
//    { 
//        $time_1=$k[$z];
//        $time_2=$k[$z+1];

//     $query = "SELECT  AVG(wait) AS avg_wait FROM entries WHERE cast(startedDateTime as Time) BETWEEN '$time_1' AND '$time_2'  ";
    
//     $query_run = mysqli_query($conn, $query);
//     if (!$query_run)
//     {
//      printf("Error: %s\n", mysqli_error($conn));
//      exit();
//     }
//     $avg_wait= mysqli_fetch_array($query_run);
   
//     $avg_wait=$avg_wait['avg_wait'];
//      $z=$z+2;
//      $data[$i]=$avg_wait;
//    }
  

//         echo json_encode($data);


        




        
       

?>