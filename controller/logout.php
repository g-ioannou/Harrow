<?php

//destroy
session_start();
var_dump($_SESSION);
session_destroy();
header('Location: /harrow/view/login/login.html');
