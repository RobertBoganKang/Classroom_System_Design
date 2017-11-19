<?php
/*connect database*/
include __DIR__ . "/../connect_inc.php";
/*pass variables*/
$username = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["userName"]));
$email = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["email"]));
$pswd = mysqli_real_escape_string($db, $_POST["password"]);
$pswd2 = mysqli_real_escape_string($db, $_POST["password2"]);
$fname = $ckcls->trimText(strtolower(mysqli_real_escape_string($db, $_POST["fname"])));
$lname = $ckcls->trimText(strtolower(mysqli_real_escape_string($db, $_POST["lname"])));
$phone = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["phone"]));
$address = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["address"]));
$password = md5($_POST["password"]);


/*check username*/
$ckcls->ckUsername($db, $username, $nameErr);
if ($nameErr != '') {
    array_push($errorArr, 'username');
}

/*check email*/
$ckcls->ckEmail($db, $email, $emailErr);
if ($emailErr != '') {
    array_push($errorArr, 'email');
}

/*check office*/
if (isset($office)) {
    /*add dimensions*/
    $office = $ckcls->trimText(mysqli_real_escape_string($db, $_POST["office"]));
    /*check office*/
    $ckcls->ckOffice($office, $officeErr);
    if ($officeErr != '') {
        array_push($errorArr, 'office');
    }
}

/*check password*/
$ckcls->ckPassword($pswd, $pswd2, $pswdErr, $pswdErr2);
if ($pswdErr != '') {
    array_push($errorArr, 'password');
    /*if error clear all password*/
    $pswd = $pswd2 = "";
}
if ($pswdErr2 != '') {
    array_push($errorArr, 'password2');
    /*if error clear the repeated password*/
    $pswd2 = "";
}

/*first-name error*/
$ckcls->ckFirstname($fname, $fnameErr);
if ($fnameErr != '') {
    array_push($errorArr, 'fname');
}

/*last-name error*/
$ckcls->ckLastname($fnameErr, $lnameErr, $lname);
if ($lnameErr != '') {
    array_push($errorArr, 'lname');
}

/*phone check*/
$ckcls->ckPhone($phone, $phoneErr);
if ($phoneErr != '') {
    array_push($errorArr, 'phone');
}

/*first error location*/
if (count($errorArr) <= 1) {
    $errorFirstLocation = $errorArr[0];
} else {
    $errorFirstLocation = $errorArr[1];
}