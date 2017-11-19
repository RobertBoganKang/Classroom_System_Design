<?php

require_once "stringUtils.php";

class checkUtils extends stringUtils
{
    public function ckEmail($db, $email, &$emailErr)
    {
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
    }

    public function ckUsername($db, $username, &$nameErr)
    {
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
    }

    public function ckOffice($office, &$officeErr)
    {
        if (empty($office)) {
            $officeErr = "Office location is required";
        }
    }

    public function ckPassword($pswd, $pswd2, &$pswdErr, &$pswdErr2)
    {
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
    }

    public function ckFirstname($fname, &$fnameErr)
    {
        if (empty($fname)) {
            $fnameErr = "First Name is required";
        } elseif (preg_match("/[^a-z]/i", $fname)) {
            $fnameErr = "First Name Invalid Format";
        }
    }

    public function ckLastname($fnameErr, &$lnameErr, $lname)
    {
        /*Firstname and lastname space style*/
        $fnamespace = $fnameErr == '' ? '' : "; ";
        if (empty($lname)) {
            $lnameErr = $fnamespace . "Last Name is required";
        } elseif (preg_match("/[^a-z]/i", $lname)) {
            $lnameErr = $fnamespace . "Last Name Invalid Format";
        }
    }

    public function ckPhone($phone, &$phoneErr)
    {
        if (!(preg_match("/^[1-9][0-9]*$/", $phone) || $phone == '')) {
            $phoneErr = "> Digit only for phone number";
        }
    }
}