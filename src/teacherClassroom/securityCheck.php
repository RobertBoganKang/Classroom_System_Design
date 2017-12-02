<?php
/*check the login status*/
try {
    session_start();
    /*connect to database*/
    include "../inc/connect_inc.php";
    /*load php functions*/
    require_once "../inc/courseUtil.php";
    require_once "../inc/stringUtils.php";
    $coursecls = new courseUtil();
    $stringcls = new stringUtils();

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