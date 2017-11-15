<?php
$nameErr = "";
$pswdErr = " ";
$username = $password = $pswd = $remember = "";
/*type true: student, false: teacher*/
$type = 1;
$result = "";
/*autofocus place*/
$errorArr = array('');
$errorFirstLocation = 'username';
/*remember time*/
$memtime = 7;
/*text trim*/
include "stringUtils.php";
$strcls = new stringUtils();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        /*all variables, automatic login*/
        include "../inc/connect_inc.php";
        if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && $_SERVER["REQUEST_METHOD"] != "POST") {
            $pswd = "not empty";
            $username = $_COOKIE['username'];
            $password = $_COOKIE['password'];
        } else {
            $username = $strcls->trimText(mysqli_real_escape_string($db, $_POST["userName"]));
            $pswd = mysqli_real_escape_string($db, $_POST["password"]);
            $password = md5($_POST["password"]);
            $remember = (isset($_POST['remember']) && $_POST['remember'] == 'yes') ? "yes" : "no";
        }

        /*check name*/
        if (empty($username)) {
            $nameErr = "Please type something here";
        } else {
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                $q1 = mysqli_query($db, "SELECT * FROM student WHERE email ='$username';");
                if (!$q1) {
                    throw new Exception($db->error);
                }
                $q2 = mysqli_query($db, "SELECT * FROM teacher WHERE email ='$username';");
                if (!$q2) {
                    throw new Exception($db->error);
                }
                $r1 = mysqli_num_rows($q1);
                $r2 = mysqli_num_rows($q2);
                if ($r1 + $r2 < 1) {
                    $nameErr = "Invalid email address";
                } elseif ($r2 > 0) {
                    $result = $q2;
                    $type = 0;
                } else $result = $q1;
            } else {
                $q1 = mysqli_query($db, "SELECT * FROM student WHERE BINARY username ='$username';");
                if (!$q1) {
                    throw new Exception($db->error);
                }
                $q2 = mysqli_query($db, "SELECT * FROM teacher WHERE BINARY username ='$username';");
                if (!$q2) {
                    throw new Exception($db->error);
                }
                $r1 = mysqli_num_rows($q1);
                $r2 = mysqli_num_rows($q2);
                if ($r1 + $r2 < 1) {
                    $nameErr = "Invalid user name";
                } elseif ($r2 > 0) {
                    $result = $q2;
                    $type = 0;
                } else $result = $q1;
            }
            if ($nameErr != '') {
                array_push($errorArr, 'username');
            }

            if ($nameErr == '') {
                /*password check*/
                if (empty($pswd)) {
                    $pswdErr = "Please type password here";
                } else {
                    $row = mysqli_fetch_assoc($result);
                    if ($password == $row['password']) {
                        setcookie('type', $type, null, '/');
                        /*find name*/
                        $persontype = $type ? 'student' : 'teacher';
                        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                            $pq = mysqli_fetch_assoc(mysqli_query($db,
                                "SELECT * FROM $persontype WHERE BINARY email ='$username';"));
                        } else {
                            $pq = mysqli_fetch_assoc(mysqli_query($db,
                                "SELECT * FROM $persontype WHERE BINARY username ='$username';"));
                        }
                        if (!$pq) {
                            throw new Exception($db->error);
                        }
                        if ($remember == "yes") {
                            setcookie('username', $row['username'], time() + 43200 * $memtime, '/');
                            setcookie('password', $row['password'], time() + 43200 * $memtime, '/');
                            setcookie('fname', $pq['fname'], time() + 43200 * $memtime, '/');
                            setcookie('lname', $pq['lname'], time() + 43200 * $memtime, '/');
                        } else {
                            setcookie('username', $row['username'], null, '/');
                            setcookie('password', $row['password'], null, '/');
                            setcookie('fname', $pq['fname'], null, '/');
                            setcookie('lname', $pq['lname'], null, '/');
                        }
                        if ($type)
                            header("Location: " . "../studentClassroom/studentMain.php");
                        else
                            header("Location: " . "../teacherClassroom/teacherMain.php");
                        exit();
                    } else {
                        $pswdErr = "Wrong password";
                    }
                }
            }
            if ($pswdErr != '' && $nameErr == '') {
                array_push($errorArr, 'password');
                /*if error clear the repeated password*/
                $pswd = "";
            }

            /*first error location*/
            if (count($errorArr) == 0) {
                $errorFirstLocation = $errorArr[0];
            } else {
                $errorFirstLocation = $errorArr[1];
            }
        }
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}