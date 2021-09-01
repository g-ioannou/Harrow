<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's homepage</title>
    <script src="https://kit.fontawesome.com/99e7bc666b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
     <script src="../../controller/home_admin.js"></script>
    <link rel="stylesheet" type="text/css" href="../../view/style/home_admin.css">
</head>

<body>
    

<div class="container">
    <div class="navigation">
        <ul>
            <li>
                <a href="#">
                <img src="../../view/images/logo.png" class="logo">
                
            </a>
            </li>
            <li class ="active">
                <a href="/harrow/view/home_admin/home_admin.php">
                <span class="icon"><i class="fas fa-home"></i></i>
                </span>
                <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/harrow/view/home_admin/diagram_admin.php">
                <span class="icon"><i class="fas fa-chart-area"></i>
                </span>
                <span class="title">Diagram</span>
                </a>            
            </li>
            <li>
                <a href="/harrow/view/home_admin/tables_admin.php">
                <span class="icon"><i class="fas fa-table"></i>
                </span>
                <span class="title">Tables/Graphs</span>
                </a>
            </li>
            <li>
                <a href="/harrow/view/home_admin/heatmap_admin.php">
                <span class="icon"><i class="fas fa-map-marked"></i>
                </span>
                <span class="title">Heatmap</span>
                </a>
            </li>
            <li>
                <a href="/harrow/view/home_admin/settings_admin.php">
                <span class="icon"><i class="fas fa-cog"></i>
                </span>
                <span class="title">Settings</span>
                </a>
            </li>
            <li>
                <a href="/harrow/controller/logout.php">
                <span class="icon"><i class="fas fa-sign-out-alt"></i>
                </span>
                <span class="title">Sign Out</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="toggle" onclick="toggleMenu()"></div>
            
           <div class="admin"><img src="../images/admin.png" ></div>
        </div>
        <div class="cardBox">
          <div class="card">
                <div class="content" id="average">
                    <div class="title">Average age of Content-Type  </div>
                   
                
                </div>
                <div class="iconBox"><i class="fas fa-clock"></i></div>
            </div>      
            <div class="card">
                <div class="content">
                    <div class="title">Types of Requests </div>
                    <span class="numbers2" id="methods"></span>
                
                </div>
                <div class="iconBox"><i class="fas fa-hand-pointer"></i></div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="title">Νumber of entries in the database per status</div>
                    <span class="numbers3" id="status"></span>
                
                </div>
                <div class="iconBox"><i class="fas fa-file-import"></i></div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="title">Number of different domains used  </div>
                    <span class="numbers4" id="domain"></span>
                
                </div>
                <div class="iconBox"><i class="fas fa-globe"></i></div>
            </div>

            <div class="card">
                <div class="content">
                    <div class="title">Number of different ISPS used  </div>
                    <span class="numbers5" id="isps"></span>
                
                </div>
                <div class="iconBox"><i class="fas fa-broadcast-tower"></i></div>
            </div>
            
         <div class="card">
                <div class ="content">
                  <div class="title" > Registered users</div>
                  <span class="numbers6" id="numbers"></span>
                </div>
             <div class="iconBox"><i class="fas fa-users"></i></div>
          </div>
      


        </div>

        
    </div>
</div>
<script >
function toggleMenu()
{
    let toggle=document.querySelector('.toggle');
    let navigation=document.querySelector('.navigation');
    let main=document.querySelector('.main');
    toggle.classList.toggle('active');
    navigation.classList.toggle('active');
    main.classList.toggle('active');


}
</script>
</body>
</html>