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

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="shortcut icon " type="image/x-icon" href="/harrow/view/images/tab_icon.png">
    <link rel="stylesheet" href="../../view/style/mapadmin.css" />

    <link rel="shortcut icon " type="image/x-icon" href="/harrow/view/images/tab_icon.png">
    <title>Harrow - Admin</title>

</head>

<body>

    <div id="mapid"></div>
    <div class="icon"><img id="the-logo" src="/harrow/view/images/logo.png" alt=""></div>
    <button id="back-to-home" class='btn'><i class="fas fa-home"></i></button>
</body>

<script src="/harrow/controller/ips_map_admin.js"></script>

</html>