<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harrow - Admin</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../controller/diagram_admin.js"></script>
    <link rel="stylesheet" type="text/css" href="../../view/style/home_admin.css">

    <script src="../../view/style/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/harrow/chart_obj.js"></script>
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
                    <a class="page-ref" href="/harrow/view/home_admin/home_admin.php">
                        <span class="icon"><i class="fas fa-home"></i></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a class="page-ref" href="/harrow/view/home_admin/diagram_admin.php">
                        <span class="icon"><i class="fas fa-chart-area"></i>
                        </span>
                        <span class="title">Avg. Time Analysis</span>
                    </a>
                </li>
                <li>
                    <a class="page-ref" href="/harrow/view/home_admin/tables_admin.php">
                        <span class="icon"><i class="fas fa-table"></i>
                        </span>
                        <span class="title">Response Analysis</span>
                    </a>
                </li>
                <li>
                    <a class="page-ref" href="/harrow/view/home_admin/map_admin.php">
                        <span class="icon"><i class="fas fa-map-marked"></i>
                        </span>
                        <span class="title">IP-Map</span>
                    </a>
                </li>
                <li>
                    <a class="page-ref" href="/harrow/controller/logout.php">
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
                echo '<img class="avatar-top-bar" src="https://avatars.dicebear.com/api/avataaars/:' . $seed . '.svg?mood[]=happy" /> <br>'; ?>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="content">
                            <div class="day-selector">

                                <div class="select-title">Data per day</div>

                                <div class="diagramm-card">
                                    <div class="buttons">


                                        <button id="select-all-day" class="select-all-btn">Select all</button>
                                        <button id="monday" class="day_choice">Monday</button>
                                        <button id="tuesday" class="day_choice">Tuesday</button>
                                        <button id="wednesday" class="day_choice">Wednesday</button>
                                        <button id="thursday" class="day_choice">Thursday</button>
                                        <button id="friday" class="day_choice">Friday</button>
                                        <button id="saturday" class="day_choice">Saturday</button>
                                        <button id="sunday" class="day_choice">Sunday</button>
                                    </div>

                                    <div id="daily_dia" class="diagramm">
                                        <canvas id="daily_chart" class="chart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="isp-selector">
                                <div class="select-title">Data per ISP</div>
                                <div class="diagramm-card">
                                    <div class="buttons">
                                        <button id="select-all-isp" class="select-all-btn">Select all</button>
                                    </div>
                                    <div id="isp_dia" class="diagramm">
                                        <canvas id="isp_chart_" class="chart"></canvas>
                                    </div>
                                </div>


                            </div>

                            <div class="method-selector">

                                <div class="select-title">Data per request method</div>
                                <div class="diagramm-card">
                                    <div class="buttons">

                                        <button id="select-all-method" class="select-all-btn">Select all</button>
                                    </div>
                                    <div id="method_dia" class="diagramm">
                                        <canvas id="method_chart" class="chart"></canvas>
                                    </div>
                                </div>


                            </div>

                            <div class="content-selector">
                                <div class="select-title" class="select-all-btn">Data per content-type</div>
                                <div class="diagramm-card">
                                    <div class="buttons">

                                        <button id="select-all-content" class="select-all-btn">Select all</button>
                                    </div>
                                    <div id="content_dia" class="diagramm">
                                        <canvas id="content_chart" class="chart"></canvas>
                                    </div>
                                </div>


                            </div>



                            <!-- <select name="select"  id="select"> 
                                <option value="All" id="all" target="Avg_Wait_Chart">All</option>
                                <option value="Content-type" id="content-type" target="Content_Type_Chart" class="single"> Content-Type</option>
                                <option value="Day" id="day" target="Day_Chart" class="single"> Day</option>
                                <option value="Method" id="method" target="Method_Chart" class="single"> Method</option>
                                <option value="ISP" id="isp" target="ISP_Chart" class="single"> ISP</option>
                            </select>  -->


                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script type=text/javascript>
            $.ajax({
                type: "POST",
                url: "../../model/admininfo.php",
                data: {
                    "type": 'initial_choices_isp'
                },
                success: function(response) {
                    // let html= `<button id="${response}" class="isp_choice">${response}</button>`;

                    //  $(".isp-selector").append(html);   
                    let isp_responses = JSON.parse(response);
                    for (const isp_array in isp_responses) {
                        const isp = isp_responses[isp_array][0];
                        let html = `<button id="${isp}" class="isp_choice">${isp}</button>`;
                        $(".isp-selector>.diagramm-card>.buttons").append(html);
                    }


                }

            });

            $.ajax({
                type: "POST",
                url: "../../model/admininfo.php",
                data: {
                    "type": 'initial_choices_content_type'
                },
                success: function(response) {

                    // $(".content-selector").append(html);

                    let content_responses = JSON.parse(response);

                    for (const content_array in content_responses) {

                        const content_type = content_responses[content_array][0];

                        let html = `<button id="${content_type}" class="content_type_choice">${content_type}</button>`;
                        $(".content-selector>.diagramm-card>.buttons").append(html);

                    }

                }
            });

            $.ajax({
                type: "POST",
                url: "../../model/admininfo.php",
                data: {
                    "type": 'initial_choices_method'
                },
                success: function(response) {
                    let method_responses = JSON.parse(response);
                    for (const method_array in method_responses) {

                        const method_type = method_responses[method_array][0];

                        let html = `<button id="${method_type}" class="method_type_choice">${method_type}</button>`;
                        $(".method-selector>.diagramm-card>.buttons").append(html);
                    }
                }
            });
        </script>
</body>

</html>

<script type=text/javascript>
    function toggleMenu() {
        let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        let main = document.querySelector('.main');
        toggle.classList.toggle('active');
        navigation.classList.toggle('active');
        main.classList.toggle('active');
    }


    // instantiating empty graphs just for visuals
    var ctx1 = document.getElementById("content_chart").getContext("2d");
    var ctx2 = document.getElementById("isp_chart_").getContext("2d");
    var ctx3 = document.getElementById("method_chart").getContext("2d");
    var ctx4 = document.getElementById("daily_chart").getContext("2d");

    var chart = new Chart(ctx1, {
        response:"true",
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

    var chart = new Chart(ctx2, {
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
    var chart = new Chart(ctx3, {
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

    var chart = new Chart(ctx4, {
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
</script>