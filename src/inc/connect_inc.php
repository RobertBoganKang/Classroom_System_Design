<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "classroom";

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

