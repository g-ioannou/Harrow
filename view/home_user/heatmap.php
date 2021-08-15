<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="/harrow/view/style/heatmap.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <title>Document</title>
</head>


<body>

    <div id="map"></div>
    <button id="back-to-home" class='btn'><i class="fas fa-home"></i></button>
    <button id="open-panel" class="btn"><i class="fas fa-cog"></i></button>
    <div class="legend">less <span id="more">more</span> </div>
    <button id="legend-tip" class="btn"><i class="fas fa-question"></i></button>

    <div class="legend-info" hidden>Color is adjusted based on the percentage of appearances of an IP address to the total ammount of IP addresses given. <br><br> Zoom in for better results.</div>
    <div class="side-panel">
        <div class="panel-icon"><i class="fas fa-cog"></i></div>

        <button id="close-side-panel"><i class="fas fa-times"></i></button><br>
        <span id='select-msg'>Select files to display on map.</span>
        <div class="file-list-container">
            <table class="file-list">
                <th></th>
                <th><i class="fas fa-file"></i></th>
            </table>
        </div>

        <button id="select-all" class="btn">select all</button>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script type="text/javascript" src="/harrow/view/style/leaflet-heat.js"></script>
    <script type="text/javascript" src="/harrow/view/style/heatmap.js"></script>


</body>

</html>