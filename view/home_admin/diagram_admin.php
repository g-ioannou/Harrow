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
            <li >
                <a href="/harrow/view/home_admin/home_admin.php">
                <span class="icon"><i class="fas fa-home"></i></i>
                </span>
                <span class="title">Dashboard</span>
                </a>
            </li>
            <li class ="active">
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
                <span class="title">Data Optimization</span>
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

    <div class="container">
        <h3 allign="center">Diagrams</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-9">
                        <h3 class="panel-title">Dkjnckjnsc</h3>
                    </div>
                    <div class="col-md-3">
                        <select name="data" class="form-control" id="data">
                            <option value="">SELECT</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="topbar">
            <div class="toggle" onclick="toggleMenu()"></div>
            <div class="search">
                <label >
                    <input type="text" placeholder="search here">
                    <i class="fas fa-search"></i>
                </label>
           </div>
           <div class="admin"><img src="../images/admin.png" ></div>
        </div>
       

        
    </div>
</div>
<script type=".././controller/diagram_admin.js" src="https://www.gstatic.com/charts/
loader.js"></script>
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