<?php
/*connect database*/
include __DIR__ . "/../connect_inc.php";
/*pass variables*/
$username = $strcls->trimText(mysqli_real_escape_string($db, $_POST["userName"]));
$email = $strcls->trimText(mysqli_real_escape_string($db, $_POST["email"]));
$pswd = mysqli_real_escape_string($db, $_POST["password"]);
$pswd2 = mysqli_real_escape_string($db, $_POST["password2"]);
$fname = $strcls->trimText(strtolower(mysqli_real_escape_string($db, $_POST["fname"])));
$lname = $strcls->trimText(strtolower(mysqli_real_escape_string($db, $_POST["lname"])));
$phone = $strcls->trimText(mysqli_real_escape_string($db, $_POST["phone"]));
$address = $strcls->trimText(mysqli_real_escape_string($db, $_POST["address"]));
$password = md5($_POST["password"]);

/*check username*/
if (empty($username)) {
    $nameErr = "Username is required";
} else {
    if (strlen($username) > 16 || strlen($username) < 6) {
        $nameErr = "User name should be 6~16 characters";
    } elseif (!ctype_alnum($username)) {
        $nameErr = "Only letters and numbers allowed";
    } elseif (!preg_match("/^[a-zA-z]/", $username)) {
        $nameErr = "User name should start with letters";
    } else {
        $r1 = mysqli_query($db, "SELECT * FROM student WHERE BINARY username ='$username';");
        if (!$r1) {
            throw new Exception($db->error);
        }
        $r2 = mysqli_query($db, "SELECT * FROM teacher WHERE BINARY username ='$username';");
        if (!$r2) {
            throw new Exception($db->error);
        }
        if (mysqli_num_rows($r1) + mysqli_num_rows($r2) != 0) {
            $nameErr = "Username has been registered";
        }
    }
}
if ($nameErr != '') {
    array_push($errorArr, 'username');
}

/*check email*/
if (empty($email)) {
    $emailErr = "Email is required";
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $r1 = mysqli_query($db, "SELECT * FROM student WHERE email ='$email';");
        if (!$r1) {
            throw new Exception($db->error);
        }
        $r2 = mysqli_query($db, "SELECT * FROM teacher WHERE email ='$email';");
        if (!$r2) {
            throw new Exception($db->error);
        }
        if (mysqli_num_rows($r1) + mysqli_num_rows($r2) != 0) {
            $emailErr = "Email has been registered";
        }
    }
}
if ($emailErr != '') {
    array_push($errorArr, 'email');
}

/*check password*/
if (empty($pswd)) {
    $pswdErr = "Password is required";
} else {
    if (strlen($pswd) < 6 || strlen($pswd) > 16) {
        $pswdErr = "Password should be 6~16 characters";
    } elseif (preg_match("/\s/", $pswd)) {
        $pswdErr = "Password cannot contain space";
    } elseif ($pswd != $pswd2) {
        $pswdErr = "";
        $pswdErr2 = "Password do not match";
    } else {
        $pswdErr = $pswdErr2 = "";
    }
}
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
if (empty($fname)) {
    $fnameErr = "First Name is required";
} elseif (preg_match("/[^a-z]/i", $fname)) {
    $fnameErr = "First Name Invalid Format";
}
if ($fnameErr != '') {
    array_push($errorArr, 'fname');
}

/*last-name error*/
$fnamespace = $fnameErr == '' ? '' : "; ";
if (empty($lname)) {
    $lnameErr = $fnamespace . "Last Name is required";
} elseif (preg_match("/[^a-z]/i", $lname)) {
    $lnameErr = $fnamespace . "Last Name Invalid Format";
}
if ($lnameErr != '') {
    array_push($errorArr, 'lname');
}

/*phone check*/
if (!(preg_match("/^[1-9][0-9]*$/", $phone) || $phone == '')) {
    $phoneErr = "> Digit only for phone number";
}
if ($phoneErr != '') {
    array_push($errorArr, 'phone');
}