<?php
session_start();
require "../inc/connect_inc.php";
try {
    /*get variables*/
    $uploads = $_FILES['uploadFile'];
    $course_id = $_POST['course_id'];
    $category = $_POST['menu'];

    /*files variables*/
    $target_dir = "../files/";

    /*error message*/
    $_SESSION['uploadErr'] = "";
//print_r($uploads);
    if ($category != '') {
        for ($i = 0; $i < count($uploads['name']); $i++) {
            $fileName = $uploads['name'][$i];
            $fileSize = $uploads['size'][$i];
            /*get name and extension*/
            $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            /*check file exist*/
            $existCheck = mysqli_query($db, "SELECT * FROM t2s WHERE filename='$withoutExt' AND course_id='$course_id'");
            if (!$existCheck) {
                throw new Exception($db->error);
            }
            if (mysqli_num_rows($existCheck) > 0) {
                $_SESSION['uploadErr'] .= "File [" . $fileName . "] exist; ";
            } /*Check file size*/
            elseif ($uploads['size'][$i] > 5242880) {
                $_SESSION['uploadErr'] .= "File [" . $fileName . "] is larger than 5 MB; ";
            }

            /*check can I upload*/
            if ($_SESSION['uploadErr'] != '') {
                $_SESSION['uploadErr'] .= "Your file [" . $fileName . "] was not uploaded; ";
            } else {
                $insertSQL = mysqli_query($db, "INSERT INTO t2s (id, course_id, filename, format, category, create_time) VALUES (null, '$course_id','$withoutExt', '$ext', '$category', NOW());");
                if (!$insertSQL) {
                    throw new Exception($db->error);
                }
                $fileID = mysqli_insert_id($db);
                $target_file = $target_dir . basename($fileID . "." . $ext);
                $checkUpload = move_uploaded_file($uploads["tmp_name"][$i], $target_file);
                if (!$checkUpload) {
                    $_SESSION['uploadErr'] .= "There was an error uploading your file [" . $fileName . "]; ";
                    $deleteSQL = mysqli_query($db, "DELETE FROM t2s WHERE id=$fileID");
                    if (!$deleteSQL) {
                        throw new Exception($db->error);
                    }
                    unlink($target_file);
                }
            }
        }
    } else {
        $_SESSION['uploadErr'] = "Category cannot be empty!";
    }
    if ($_SESSION['uploadErr'] != '') {
        $_SESSION['uploadErr'] = "Warning: " . $_SESSION['uploadErr'];
        header("Location:" . "uploadFile.php");
        $_SESSION['course_id'] = $course_id;
        if ($category != '') {
            $_SESSION['menu'] = $category;
        }
    } else {
        header("Location:" . "classroomUpload.php?course_id=" . $course_id . "&menu=" . $category);
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}