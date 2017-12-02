<?php
/*for security reason, check the login status*/
require "securityCheck.php";

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