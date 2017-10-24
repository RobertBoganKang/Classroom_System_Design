<?php
/*if no error*/
if ($nameErr == '' && $emailErr == '' && $pswdErr == '' && $pswdErr2 == '' && $fnameErr == '' && $lnameErr == '' && $officeErr == '' && $phoneErr == '') {
    $sql = "INSERT INTO teacher (id, username, fname, lname, email, phone, address, password, office) VALUE(NULL, '$username', '$fname', '$lname', '$email', '$phone', '$address', '$password', '$office');";
    $qr = mysqli_query($db, $sql);
    if (!$qr) {
        throw new Exception($db->error);
    }
    setcookie('username', $username, null, '/');
    setcookie('type', 0, null, '/');
    setcookie('fname', $fname, null, '/');
    setcookie('lname', $lname, null, '/');
    header("Location: " . "../teacherClassroom/teacherMain.php");
    exit();
}