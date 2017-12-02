<?php
/*for security reason, check the login status*/
require "securityCheck.php";

try {
    /*get values*/
    $course_id = $_GET['course'];
    $semester_id = $_GET['semester'];

    /*get teacher id*/
    $myID = $pq['id'];

    /*user's cannot hack our system by manipulating URLs; safety check*/
    $check = mysqli_query($db, "SELECT * FROM course WHERE id=$course_id AND teacher_id=$myID");
    if (!$check) {
        throw new Exception($db->error);
    }
    if (mysqli_num_rows($check) < 1) {
        throw new Exception("Please do not hack our system!");
    }

    /*delete course and go back*/
    $deleteCourse = mysqli_query($db, "DELETE FROM semcourse WHERE course_id=$course_id AND semester_id=$semester_id");
    header("Location: " . "manageCourse.php?menu=1&&semester=$semester_id");

} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}