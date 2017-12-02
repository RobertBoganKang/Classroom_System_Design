<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../js/rememberScroll.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/overall.css">
    <?php include "../inc/setStyle_inc.php" ?>
</head>
<body>
<?php
/*for security reason, check the login status*/
require "securityCheck.php";

/*type true: student, false: teacher*/
$type = 0;
?>
<div class="panel">
    <div class="nav">
        <a href="teacherMain.php">Home</a>
        / <a href="../loginSystem/logout.php">Logout</a>
    </div>