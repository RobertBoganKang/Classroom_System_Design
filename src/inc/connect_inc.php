<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "classroom";

/*start session*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../errorPage/errorPageFunc.php";
$cls = new errorPageFunc();

try {
    $db = mysqli_connect($servername, $username, $password, $database);
    if (mysqli_connect_error()) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Exception $e) {
    $cls->sendErrMsg($e->getMessage());
}

