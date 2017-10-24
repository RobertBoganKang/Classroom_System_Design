<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/loginSystemStyle.css">
</head>
<body>
<?php
/*if session not work, redirect to sign-in*/
if (!isset($_COOKIE['username']) || !$_COOKIE['type']) {
    include_once "../loginSystem/logout.php";
    exit();
}
?>
<div class="panel">
    <div class="nav">
        <a href="studentMain.php">Home</a>
        / <a href="settingStudent.php">Setting</a>
        / <a href="../loginSystem/logout.php">Logout</a>
    </div>