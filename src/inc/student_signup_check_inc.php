<?php
$nameErr = $emailErr = $pswdErr = $fnameErr = $phoneErr = $lnameErr = "";
$pswdErr2 = " ";
$username = $email = $phone = $pswd = $pswd2 = $fname = $lname = $address = "";
/*autofocus place*/
$errorArr = array('');
$errorFirstLocation = 'username';
/*text trim*/
include 'checkUtils.php';
$ckcls = new checkUtils();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "signUpCodeAssemble/sameCheckCode.php";
        include "signUpCodeAssemble/postCode4Student.php";
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
