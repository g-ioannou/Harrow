<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin's homepage</title>
    <script src="https://kit.fontawesome.com/99e7bc666b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../controller/diagram_admin.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                <li>
                    <a href="/harrow/view/home_admin/home_admin.php">
                        <span class="icon"><i class="fas fa-home"></i></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="active">
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
                echo '<img class="avatar-top-bar" src="https://avatars.dicebear.com/api/avataaars/:' . $seed . '.svg?mood[]=happy" /> <br>'; ?>
            </div>

            <h3 allign="center">Diagrams</h3>
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="panel-title">Response Time Analysis</h3>
                        </div>
                        <div class="col-md-3">
                            <div class="buttons">
                                <div class="day-selector">
                                    Select data per day.
                                    <button id="select-all-day">Select all</button>
                                    <button id="monday" class="day_choice">Monday</button>
                                    <button id="tuesday" class="day_choice">Tuesday</button>
                                    <button id="wednesday" class="day_choice">Wednesday</button>
                                    <button id="thursday" class="day_choice">Thursday</button>
                                    <button id="friday" class="day_choice">Friday</button>
                                    <button id="saturday" class="day_choice">Saturday</button>
                                    <button id="sunday" class="day_choice">Sunday</button>

                                </div>
                                <div class="isp-selector">
                                    Select data per ISP.
                                    <button id="select-all-isp">Select all</button>
                                </div>

                                <div class="method-selector">
                                    Select data per request method.
                                    <button id="select-all-method">Select all</button>
                                </div>

                                <div class="content-selector">
                                    Select data per content-type.
                                    <button id="select-all-content">Select all</button>
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



                <div class="panel-body" id="panel-body">
                    <canvas id="Avg_Wait_Chart" class="all">I am all</canvas>
                    <canvas id="Content_Type_Chart" class="single">2</canvas>
                    <canvas id="Day_Chart" class="single">3</canvas>
                    <canvas id="Method_Chart" class="single">4</canvas>
                    <canvas id="ISP_Chart" class="single">5</canvas>
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
                        $(".isp-selector").append(html);
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
                        $(".content-selector").append(html);

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
                        
                        $(".method-selector").append(html);
                    }
                }
            });

            //       }
            //   });
            //   $.ajax({
            //       type: "method",
            //       url: "url",
            //       data: {"type": 'initial_choices_isp'},
            //       success: function (response) {
            //           // kane to button append kapou
            //           $(".isp-selector").append(response);

            //       }
            //   });

            //   $(document).ready(function () 
            //     $.ajax({
            //                 method: "POST",
            //                 url: "../../model/admininfo.php",
            //                 data:
            //                 {
            //                     type: "Avg_Wait_Chart", // initial_choices
            //                     dataType: "JSON"
            //                 },

            //                  success: function (response) {



            //                 let myChart=document.getElementById('Avg_Wait_Chart').getContext('2d');
            //                 let barChart=   new Chart(myChart,{
            //                     type:'bar',
            //                     data:{
            //                         labels:["00:00-00:59","01:00-01:59","02:00-02:59","03:00-03:59","04:00-04:59","05:00-05:59",
            //                         "06:00-06:59","07:00-07:59","08:00-08:59","00:09-09:59","10:00-10:59",
            //                         "11:00-11:59","12:00-12:59","13:00-13:59","14:00-14:59","15:00-15:59","16:00-16:59",
            //                         "17:00-17:59","18:00-18:59","19:00-19:59","20:00-20:59","21:00-21:59","22:00-22:59","23:00-00:59","23:00-00:59"],
            //                         datasets:[
            //                             {
            //                                 label:'Average Wait',
            //                                 data: JSON.parse(response)
            //                             }
            //                         ]
            //                     },
            //                     options:{}
            //                                            });

            //                                         });
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
</script>