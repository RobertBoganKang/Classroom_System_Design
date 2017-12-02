<?php
/*for security reason, check the login status*/
require "securityCheck.php";

try {
    /*get values*/
    $start = htmlspecialchars($_GET['advStart']);
    $cstart = $_GET['advStart'] . ":00";
    $end = htmlspecialchars($_GET['advEnd']);
    $cend = $_GET['advEnd'] . ":00";
    $course_id = $_GET['course'];
    $semester_id = $_GET['semester'];
    $room = $stringcls->trimText($_GET['office']);
    $week = $_GET['advWeek'];

    /*check time violence*/
    $myID = $pq['id'];
    $joinedTableSQL = "SELECT *
FROM (SELECT course.cname AS cname, course.teacher_id AS teacher_id, course.cname AS course_name, semcourse.week AS week, semcourse.cstart AS cstart, semcourse.cend AS cend, semcourse.semester_id AS semester_id FROM semcourse JOIN course ON course.id=semcourse.course_id) AS t
WHERE teacher_id=$myID AND semester_id=$semester_id";
    $checkcourse = mysqli_query($db, $joinedTableSQL);
    if (!$checkcourse) {
        throw new Exception($db->error);
    }
    /*check time violence*/
    $checkcourseErr = "";
    if (mysqli_num_rows($checkcourse) > 0) {
        $courseweekarr = str_split($week);
        while ($row = mysqli_fetch_assoc($checkcourse)) {
            foreach ($courseweekarr as $weekA) {
                /*find if week has matched*/
                if (strpos($row['week'], $weekA) !== false) {
                    echo $weekA . " " . $row['week'] . " " . strpos("abc", "d");
                    /*find time interval has overlap*/
                    if (($cstart > $row['cstart'] && $cstart < $row['cend']) || ($cend > $row['cstart'] && $cend < $row['cend'])) {
                        $checkcourseErr = "[" . $row['cname'] . " @ " . $coursecls->shortenTime($row['cstart']) . " ~ " . $coursecls->shortenTime($row['cend']) . "] took up the time for this course";
                        break;
                    }
                }
            }
        }
    }
    /*if violate, print something back to the page*/
    $_SESSION['checkcourseErr'] = $checkcourseErr;
    if ($checkcourseErr == '') {
        /*no error*/
        header("Location: " . "manageCourse.php?menu=0&semester=$semester_id");
        if ($cstart != '' && $cend != '' && $course_id != '' && $semester_id != '' && $room != '' && $week != '') {
            $openCourseSQL = mysqli_query($db, "INSERT INTO semcourse (id, course_id, semester_id,room, week, cstart, cend)
VALUES (NULL, '$course_id', '$semester_id','$room', '$week', '$cstart', '$cend');");
            if (!$openCourseSQL) {
                throw new Exception($db->error);
            }
            /*refresh addcourse*/
            require "refreshAddcourse.php";
        } else {
            throw new Exception("Please do not hack our system!");
        }
    } else {
        /*has error*/
        header("Location: " . "manageCourse.php?menu=0&course=$course_id&semester=$semester_id&advWeek=$week&advCstart=$start&advCend=$end&advRoom=$room");
    }

} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}

