<?php
/*initialize all variables*/
$phone = $phoneErr = $address = $addressErr = "";
/*text trim*/
include "stringUtils.php";
$strcls = new stringUtils();

try {
    $phone = $pq['phone'];
    $address = $pq['address'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        /*pass variables*/
        $phone = $strcls->trimText(mysqli_real_escape_string($db, $_POST["phone"]));
        $address = $strcls->trimText(mysqli_real_escape_string($db, $_POST["address"]));

        /*phone check*/
        if (!(preg_match("/^[1-9][0-9]*$/", $phone) || $phone == '')) {
            $phoneErr = "Digit only for phone number";
        }

        if ($phoneErr == '' && $addressErr == '') {
            /*post information*/
            $uname = $_COOKIE['username'];
            $sql = "UPDATE student SET phone = '$phone', address = '$address' WHERE username = '$uname'";
            $qr = mysqli_query($db, $sql);
            if (!$qr) {
                throw new Exception($db->error);
            }
        }
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
