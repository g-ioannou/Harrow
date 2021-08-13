<?php
session_start();
session_destroy();
header('Location: /harrow/view/login/login.html');
