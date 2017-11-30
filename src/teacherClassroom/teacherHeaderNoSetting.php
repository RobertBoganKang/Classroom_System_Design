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
try {
    session_start();
    /*connect to database*/
    include "../inc/connect_inc.php";
    if (!isset($_SESSION['pq'])) {
        /*get info*/
        $username = $_COOKIE['username'];
        $p = mysqli_query($db, "SELECT * FROM teacher WHERE BINARY username ='$username';");
        if (!$p) {
            throw new Exception($db->error);
        }
        $pq = mysqli_fetch_assoc($p);
        if (!$pq) {
            throw new Exception($db->error);
        }
        /*session pq just used for check status, no need to query all the time*/
        $_SESSION['pq'] = $pq;
    } else {
        $pq = $_SESSION['pq'];
    }
    if ($pq['password'] != $_COOKIE['password']) {
        include_once "../loginSystem/logout.php";
        exit();
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
/*type true: student, false: teacher*/
$type = 0;
?>
<div class="panel">
    <div class="nav">
        <a href="teacherMain.php">Home</a>
        / <a href="../loginSystem/logout.php">Logout</a>
    </div>