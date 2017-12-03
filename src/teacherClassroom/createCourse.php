<?php
/*for security reason, check the login status*/
require "securityCheck.php";

try {
    /*load php functions*/
    require_once "../inc/stringUtils.php";
    $stringcls = new stringUtils();

    /*get all variables*/
    $cname = $stringcls->trimText($_POST['cname']);
    $detail = $stringcls->trimText($_POST['detail']);
    $teacher_id = $pq['id'];

    /*check duplicated create*/
    $duplicate = mysqli_query($db, "SELECT * FROM course WHERE cname='$cname' AND teacher_id='$teacher_id'");
    if (!$duplicate) {
        throw new Exception($db->error);
    }

    if (mysqli_num_rows($duplicate) > 0) {
        $_SESSION['createCourseErr'] = "Error: the course [$cname] has already in our database.";
    }

    if ($cname != '' && $detail != '' && !isset($_SESSION['createCourseErr'])) {
        $createCourse = mysqli_query($db, "INSERT INTO course (id, cname, detail, teacher_id, rating, nrating) VALUES (null,'$cname','$detail','$teacher_id',0,0)");
        if (!$createCourse) {
            throw new Exception($db->error);
        }
    }
    header("Location: " . "manageCourse.php?menu=2");
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}