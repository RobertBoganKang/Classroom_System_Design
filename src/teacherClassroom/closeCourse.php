<?php
/*for security reason, check the login status*/
require "securityCheck.php";

try {
    /*get values*/
    $course_id = $_POST['course'];
    $semester_id = $_POST['semester'];

    /*delete course and go back*/
    $deleteCourse = mysqli_query($db, "DELETE FROM semcourse WHERE course_id=$course_id AND semester_id=$semester_id");
    $deleteMyStudent =mysqli_query($db, "DELETE FROM stucourse WHERE course_id=$course_id AND semester_id=$semester_id");
    /*refresh addcourse*/
    require "refreshAddcourse.php";
    header("Location: " . "manageCourse.php?menu=1&&semester=$semester_id");
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}