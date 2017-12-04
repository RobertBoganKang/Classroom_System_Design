<?php
include "../inc/connect_inc.php";
$course_id = $_POST['course_id'];
$student_id = $_POST['student_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

try {
    /*find my old rating*/
    $stucourse = mysqli_fetch_assoc(mysqli_query($db, "SELECT rating FROM stucourse WHERE student_id=$student_id AND course_id=$course_id"));
    if (!$stucourse) {
        throw new Exception($db->error);
    }
    $course = mysqli_fetch_assoc(mysqli_query($db, "SELECT rating, nrating FROM course WHERE id=$course_id"));
    if (!$course) {
        throw new Exception($db->error);
    }

    /*calculate rating*/
    $oldRating = $stucourse['rating'];
    $nrating = $course['nrating'];
    $ratings = $course['rating'];
    if ($oldRating == 0) {
        $nrating++;
    }
    $newRating = bcdiv($nrating * $ratings - $oldRating + $rating, $nrating, 16);
    $updateStucourse = mysqli_query($db, "UPDATE stucourse SET rating=$rating, comment='$comment' WHERE student_id=$student_id AND course_id=$course_id");
    if (!$updateStucourse) {
        throw new Exception($db->error);
    }
    $updateCourse = mysqli_query($db, "UPDATE course SET rating=$newRating, nrating=$nrating WHERE id=$course_id");
    if (!$updateCourse) {
        throw new Exception($db->error);
    }
    include "../teacherClassroom/refreshAddcourse.php";
    header('Location:' . 'classroomDownload.php?course_id=' . $course_id);
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}