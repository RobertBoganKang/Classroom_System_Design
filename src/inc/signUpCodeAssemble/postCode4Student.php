<?php
/*if no error*/
if ($nameErr == '' && $emailErr == '' && $pswdErr == '' && $pswdErr2 == '' && $fnameErr == '' && $lnameErr == '' && $phoneErr == '') {
    $sql = "INSERT INTO student (id, username, fname, lname, email, phone, address, password, status) VALUE(NULL, '$username', '$fname', '$lname', '$email', '$phone', '$address', '$password', 1);";
    $qr = mysqli_query($db, $sql);
    if (!$qr) {
        throw new Exception($db->error);
    }
    setcookie('username', $username, null, '/');
    setcookie('password', $password, null, '/');
    header("Location: " . "../studentClassroom/studentMain.php");
    exit();
}