<?php
/*initialize all variables*/
$phone = $phoneErr = $address = $addressErr = $office = $officeErr = "";
/*text trim*/
include "checkUtils.php";
$ckcls = new checkUtils();

try {
    /*if using the session, do query again*/
    if (!isset($q)) {
        /*connect database*/
        include "../inc/connect_inc.php";
        /*get info*/
        $username = $_COOKIE['username'];
        if ($type == 1) {
            $p = mysqli_query($db, "SELECT * FROM student WHERE BINARY username ='$username';");
        } else {
            $p = mysqli_query($db, "SELECT * FROM teacher WHERE BINARY username ='$username';");
        }
        $pq = mysqli_fetch_assoc($p);
        if (!$pq) {
            throw new Exception($db->error);
        }
    }
    $phone = $pq['phone'];
    $address = $pq['address'];
    if ($type == 0) $office = $pq['office'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        /*pass variables*/
        $phone = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["phone"]));
        $address = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["address"]));

        /*phone check*/
        if (!(preg_match("/^[1-9][0-9]*$/", $phone) || $phone == '')) {
            $phoneErr = "Digit only for phone number";
        }

        if ($phoneErr == '' && $addressErr == '') {
            /*post information*/
            $uname = $_COOKIE['username'];
            if ($type == 1) {
                $sql = "UPDATE student SET phone = '$phone', address = '$address' WHERE username = '$uname'";
            } else {
                $sql = "UPDATE teacher SET phone = '$phone', address = '$address' WHERE username = '$uname'";
            }
            $qr = mysqli_query($db, $sql);
            if (!$qr) {
                throw new Exception($db->error);
            }
        }

        /*teacher has office*/
        if ($type == 0) {
            $office = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["office"]));
            /*check office*/
            if (isset($office)) {
                /*add dimensions*/
                $office = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["office"]));

                /*check office*/
                $ckcls->ckOffice($office, $officeErr);
            }
            /*update office*/
            if ($officeErr == '') {
                $sql = "UPDATE teacher SET office = '$office'";
                $qr = mysqli_query($db, $sql);
            }
        }
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
