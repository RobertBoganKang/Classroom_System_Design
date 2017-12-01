<?php
/*for security reason, I must check the login status*/
try {
    session_start();
    /*connect to database*/
    include "../inc/connect_inc.php";
    if (!isset($_SESSION['pq'])) {
        /*get info*/
        $username = $_COOKIE['username'];
        $p = mysqli_query($db, "SELECT * FROM student WHERE BINARY username ='$username';");
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

/*get all data*/
$state = $_GET['state'];
$student_id = $_GET['student_id'];
$course_id = $_GET['course_id'];
try {
    if ($state == 2) {
        $query = mysqli_query($db, "UPDATE stucourse SET grade='W' WHERE student_id = $student_id AND course_id = $course_id");
        if (!$query) {
            throw new Exception($db->error);
        }
    } elseif ($state == 1) {
        $query = mysqli_query($db, "UPDATE stucourse SET grade='O' WHERE student_id = $student_id AND course_id = $course_id");
        if (!$query) {
            throw new Exception($db->error);
        }
    } else {
        $query = mysqli_query($db, "DELETE FROM stucourse WHERE student_id = $student_id AND course_id = $course_id");
        if (!$query) {
            throw new Exception($db->error);
        }
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
header("Location:" . "manageCourse.php?menu=1");