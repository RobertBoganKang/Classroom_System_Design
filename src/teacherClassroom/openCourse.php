<?php
/*for security reason, check the login status*/
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


try {
    /*get values*/
    $cstart = $_GET['advStart'];
    $cend = $_GET['advEnd'];
    $course_id = $_GET['course'];
    $semester_id = $_GET['semester'];
    $room = $_GET['office'];
    $week = $_GET['advWeek'];
    echo $cstart . $cend . $course_id . $semester_id . $room . $week;
//    if ($cstart != '' && $cend != '' && $course_id != '' && $semester_id != '' && $room != '' && $week != '') {
        $openCourseSQL = mysqli_query($db, "INSERT INTO semcourse (id, course_id, semester_id,room, week, cstart, cend)
VALUES (NULL, '$course_id', '$semester_id','$room', '$week', '$cstart', '$cend');");

//    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
echo "hello";
