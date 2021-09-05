<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's homepage</title>
    <script src="https://kit.fontawesome.com/99e7bc666b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../controller/home_admin.js"></script>
    <link rel="stylesheet" type="text/css" href="../../view/style/home_admin.css">
    <script src="../../view/style/admin.js"></script>
</head>

<body>


    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <div class="logo_container">
                        <img src="../../view/images/logo.png" class="logo">
                    </div>

                </li>
                <li class="active">
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
                    <a href="/harrow/view/home_admin/map_admin.php">
                        <span class="icon"><i class="fas fa-map-marked"></i>
                        </span>
                        <span class="title">IP-Map</span>
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

                <?php
                $seed = rand(0, 1000);
                echo '<img class="avatar-top-bar" src="https://avatars.dicebear.com/api/avataaars/:' . $seed . '.svg?mood[]=happy" /> <br>';
                ?>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div class="content" id="average">
                        <div class="title">Average age of Content-Type </div>


                    </div>
                    <div class="iconBox"><i class="fas fa-clock"></i></div>
                </div>

                <div class="cardBox-column">
                    

                    <div class="inner-card">
                        <div class="content">
                            <div class="title">Types of Requests </div>
                            <span class="numbers" id="methods"></span>

                        </div>
                        <div class="iconBox"><i class="fas fa-hand-pointer"></i></div>
                    </div>

                    <div class="inner-card">
                        <div class="content">
                            <div class="title">Νumber of entries in the database per status</div>
                            <span class="numbers" id="status"></span>

                        </div>
                        <div class="iconBox"><i class="fas fa-file-import"></i></div>
                    </div>

                    <div class="inner-card">
                        <div class="content">
                            <div class="title">Number of different domains used </div>
                            <span class="numbers" id="domain"></span>

                        </div>
                        <div class="iconBox"><i class="fas fa-globe"></i></div>
                    </div>

                    <div class="inner-card">
                        <div class="content">
                            <div class="title"> Registered users</div>
                            <span class="numbers" id="numbers"></span>
                        </div>
                        <div class="iconBox"><i class="fas fa-users"></i></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script>
        function toggleMenu() {
            let toggle = document.querySelector('.toggle');
            let navigation = document.querySelector('.navigation');
            let main = document.querySelector('.main');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');


        }
    </script>
</body>

</html>