<?php
session_start();
include "../inc/connect_inc.php";
$pq = $_SESSION['pq'];
$cID = $_SESSION['submit_course_id'];
$semester = $_SESSION['submit_semester_id'];
$id = $_SESSION['submit_student_id'];
$sql = "INSERT INTO stucourse (id, student_id, course_id, semester_id, grade, rating, comment) VALUE(null,$id,$cID,$semester,null,null,null);";
if (!$sql) {
    throw new Exception($db->error);
}
$qr = mysqli_query($db, $sql);
if (!$qr) {
    throw new Exception($db->error);
}
session_destroy();
session_unset();
header("Location:" . "studentMain.php");