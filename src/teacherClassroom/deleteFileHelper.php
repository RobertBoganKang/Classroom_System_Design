<?php
session_start();
require "../inc/connect_inc.php";
try {
    /*get variables*/
    $file_id = $_POST['file_id'];
    $ext = $_POST['file_ext'];
    $course_id = $_POST['course_id'];
    $category = $_POST['category'];

    /*files variables*/
    $target_dir = "../files/";
    $target_file = $target_dir . basename($file_id . "." . $ext);

    $deleteSQL = mysqli_query($db, "DELETE FROM t2s WHERE id=$file_id");
    if (!$deleteSQL) {
        throw new Exception($db->error);
    }
    unlink($target_file);

    header("Location:" . "classroomUpload.php?course_id=" . $course_id . "&menu=" . $category);
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}