<?php
session_start();
require "../inc/connect_inc.php";
try {
    /*get variables*/
    $uploads = $_FILES['updateFile'];
    $course_id = $_POST['course_id'];
    $category = $_POST['menu'];
    $fileID = $_POST['file_id'];
    echo $fileID;

    /*files variables*/
    $target_dir = "../files/";

    /*error message*/
    $_SESSION['updateErr'] = "";

    $fileName = $uploads['name'];
    $fileSize = $uploads['size'];
    /*get name and extension*/
    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    if ($fileName != '') {
        /*check file extension*/
        $extensionCheck = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM t2s WHERE id='$fileID'"));
        if (!$extensionCheck) {
            throw new Exception($db->error);
        }
        if ($extensionCheck['format'] != $ext) {
            $_SESSION['updateErr'] .= "File extension [old:" . $extensionCheck['format'] . "; new: " . $ext . " ] does not match; ";
        }/*Check file size*/
        elseif ($uploads['size'] > 5242880) {
            $_SESSION['updateErr'] .= "File is larger than 5 MB; ";
        }
    } else {
        $_SESSION['updateErr'] .= "File cannot be empty; ";
    }

    /*check can I upload*/
    if ($_SESSION['updateErr'] != '') {
        $_SESSION['updateErr'] .= "Your file was not uploaded; ";
    } else {
        $target_file = $target_dir . basename($fileID . "." . $ext);
        /*remove original file*/
        unlink($target_file);
        /*make new file*/
        $checkUpload = move_uploaded_file($uploads["tmp_name"], $target_file);
        if (!$checkUpload) {
            $_SESSION['updateErr'] .= "There was an error uploading your file; ";
        }
    }

    if ($_SESSION['updateErr'] != '') {
        $_SESSION['updateErr'] = "Warning: " . $_SESSION['updateErr'];
        header("Location:" . "updateFile.php");
        $_SESSION['course_id'] = $course_id;
        $_SESSION['menu'] = $category;
        $_SESSION['file_id'] = $fileID;
    } else {
        header("Location:" . "classroomUpload.php?course_id=" . $course_id . "&menu=" . $category);
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}