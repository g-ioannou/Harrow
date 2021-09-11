<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: ../../view/login/login.html');
}
include "../../model/connection_db.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harrow - Admin</title>
    <script src="https://kit.fontawesome.com/99e7bc666b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script src="../../controller/home_admin.js"></script>
    <link rel="stylesheet" type="text/css" href="../../view/style/home_admin.css">
    <script src="../../view/style/admin.js"></script>
    <script src="../../controller/tables_admin.js"></script>

    <link rel="shortcut icon " type="image/x-icon" href="/harrow/view/images/tab_icon.png">
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
                <li>
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
                        <span class="title">Avg. Time Analysis</span>
                    </a>
                </li>
                <li class="active">
                    <a href="/harrow/view/home_admin/tables_admin.php">
                        <span class="icon"><i class="fas fa-table"></i>
                        </span>
                        <span class="title">Response Analysis</span>
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
                        <span class="icon"><i class="fas fa-door-open"></i>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="topbar">
                <div class="toggle" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
                <?php
                $seed = rand(0, 1000);
                echo '<img class="avatar-top-bar" src="https://avatars.dicebear.com/api/avataaars/:' . $seed . '.svg?mood[]=happy" /> <br>';
                ?>
            </div>

            <div class="content">
                <div class="content-selector">
                    <div class="select-title" class="select-all-btn">TTL histogram</div>
                    <div class="table-card">
                        <div class="buttons response-analysis-buttons">
                            <button id="select-all-content" class="select-all-btn">Select all</button>

                        </div>
                        <div class="charts-diagrams">
                            <div id="ttl_diagram" class="diagramm">
                                <canvas id="ttl_chart" class="chart"></canvas>
                            </div>
                            <div id="cacheability_diagramm" class="diagramm">
                                <canvas id="cacheability_pie" class="chart"></canvas>
                            </div>
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

            // instantiating empty graphs just for visuals
            var ctx1 = document.getElementById("ttl_chart").getContext("2d");

            var chart = new Chart(ctx1, {
                response: "true",
                type: "bar",
                data: {},
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });

            var ctx2 = document.getElementById("cacheability_pie").getContext("2d");

            var chart2 = new Chart(ctx2, {
                type: "pie",

                data: {
                    labels: ['others'],
                    datasets: [{
                            label: "donight1",
                            backgroundColor: ["grey"],
                            borderColor: ["grey"],
                            data: [1],


                        },

                    ]
                },
                options: {

                    plugins: {
                        legend: {
                            display: true,

                        },
                    },
                    title: {
                        display: true,
                        text: "Cacheability per content type",
                    },
                    responsive: true,

                }
            });
        </script>
</body>

</html>