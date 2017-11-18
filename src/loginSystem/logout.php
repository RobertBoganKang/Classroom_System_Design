<?php
session_start();
session_unset();
session_destroy();
setcookie("username", "", time() - 3600, '/');
setcookie("password", "", time() - 3600, '/');
ob_start();
$nameErr = $emailErr = $pswdErr = $officeErr = "";
$username = $email = $pswd = $office = "";
header("Location: " . "../index.php");
exit();