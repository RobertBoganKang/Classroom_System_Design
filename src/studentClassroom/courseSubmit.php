<?php
session_start();
include "../inc/connect_inc.php";
$pq = $_SESSION['pq'];
$cID = $_SESSION['submit_course_id'];
$semester = $_SESSION['submit_semester_id'];
$id = $_SESSION['submit_student_id'];
try {
    $sql = "INSERT INTO stucourse (id, student_id, course_id, semester_id, grade, rating, comment) VALUE(null,$id,$cID,$semester,'',null,null);";
    if (!$sql) {
        throw new Exception($db->error);
    }
    $qr = mysqli_query($db, $sql);
    if (!$qr) {
        throw new Exception($db->error);
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
header("Location:" . "studentMain.php");