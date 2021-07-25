<?php

//destroy
session_start();
unset($_SESSION['email']);
session_destroy();
header('Location: /harrow/view/login/login.html');


?>