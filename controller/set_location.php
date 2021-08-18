<?php
session_start();

$_SESSION['ip'] = $_POST['ip'];
$_SESSION['isp'] = $_POST['org'];
$_SESSION['city'] = $_POST['city'];
?>
