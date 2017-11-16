<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/overall.css">
    <link rel="stylesheet" href="../css/loginSystemStyle.css">
    <script src="../js/overall.js"></script>
    <script>
        /*textarea enter to submit*/
        textareaEnterSubmit("#address", "form");
    </script>
</head>
<body>
<?php include "../inc/student_signup_check_inc.php" ?>
<div class="panel">
    <!--navigation-->
    <div class="nav">
        <a href="signIn.php">Sign in </a>/<a href="signUpProfessor.php"> Teacher?</a>
    </div>
    <!--title-->
    <h1>Student Sign Up</h1>
    <!--form-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form" class="form">
        <div class="container-fluid align-left">
            <!--username-->
            <div class="row">
                <div class="col-sm-7"><input type="text" name="userName" id="username" placeholder="User's Name"
                                             value="<?= $username ?>"
                        <?php if ($errorFirstLocation == "username") { ?> autofocus <?php } ?>>
                </div>
                <div class="col-sm-5"><span class="error" id="usernameX">* <?php echo $nameErr; ?></span></div>
            </div>
            <!--email-->
            <div class="row">
                <div class="col-sm-7"><input type="text" name="email" id="email" placeholder="Email Address"
                                             value="<?= $email ?>"
                        <?php if ($errorFirstLocation == "email") { ?> autofocus <?php } ?>>
                </div>
                <div class="col-sm-5"><span class="error" id="emailX">* <?php echo $emailErr; ?></span></div>
            </div>
            <!--password-->
            <div class="row">
                <div class="col-sm-4"><input type="password" name="password" id="password" placeholder="Password"
                                             value="<?= $pswd ?>"
                        <?php if ($errorFirstLocation == "password") { ?> autofocus <?php } ?>></div>
                <div class="col-sm-3"><input type="password" name="password2" id="password2"
                                             placeholder="Retype Password" value="<?= $pswd2 ?>"
                        <?php if ($errorFirstLocation == "password2") { ?> autofocus <?php } ?>></div>
                <div class="col-sm-5"><span class="error" id="passwordX">* <?php echo $pswdErr . $pswdErr2; ?></span>
                </div>
            </div>
            <!--first, last name-->
            <div class="row">
                <div class="col-sm-4">
                    <input type="text" name="fname" id="fname" placeholder="First Name"
                           value="<?= $fname ?>"
                        <?php if ($errorFirstLocation == "fname") { ?> autofocus <?php } ?>>
                </div>
                <div class="col-sm-3">
                    <input type="text" name="lname" id="lname" placeholder="Last Name"
                           value="<?= $lname ?>"
                        <?php if ($errorFirstLocation == "lname") { ?> autofocus <?php } ?>>
                </div>
                <div class="col-sm-5"><span class="error" id="nameX">* <?php echo $fnameErr . $lnameErr; ?></span></div>
            </div>
            <!--phone-->
            <div class="row">
                <div class="col-sm-7"><input type="text" name="phone" id="phone" placeholder="Phone Number"
                                             value="<?= $phone ?>"
                        <?php if ($errorFirstLocation == "phone") { ?> autofocus <?php } ?>>
                </div>
                <div class="col-sm-5"><span class="error" id="phoneX"> <?php echo $phoneErr; ?></span></div>
            </div>
            <!--address-->
            <div class="row">
                <div class="col-sm-7"><textarea name="address" id="address" rows="3" placeholder="Address"></textarea>
                </div>
                <div class="col-sm-5"></div>
            </div>
            <!--submit-->
            <div class="row">
                <div class="col-sm-7"><input type="submit" value="Register" class="submit"></div>
                <div class="col-sm-5"><a href="#" class="secretdot">*</a></div>
            </div>
        </div>
    </form>
</div>
<!--scripts-->
<script>
    /*error*/
    changeBorderErr(<?php echo json_encode($nameErr); ?>, "username");
    changeBorderErr(<?php echo json_encode($emailErr); ?>, "email");
    changeBorderErr(<?php echo json_encode($pswdErr); ?>, "password");
    changeBorderErr(<?php echo json_encode($pswdErr2); ?>, "password2");
    changeBorderErr(<?php echo json_encode($fnameErr); ?>, "fname");
    changeBorderErr(<?php echo json_encode($lnameErr); ?>, "lname");
    /*pass*/
    var pass = false;
    pass = <?php echo json_encode($_SERVER["REQUEST_METHOD"] == "POST"); ?>;
    changeBorderPass(<?php echo json_encode($nameErr); ?>, pass, "username");
    changeBorderPass(<?php echo json_encode($emailErr); ?>, pass, "email");
    changeBorderPass(<?php echo json_encode($pswdErr); ?>, pass, "password");
    changeBorderPass(<?php echo json_encode($pswdErr2); ?>, pass, "password2");
    changeBorderPass(<?php echo json_encode($fnameErr); ?>, pass, "fname");
    changeBorderPass(<?php echo json_encode($lnameErr); ?>, pass, "lname");

    changeBorderPassX(<?php echo json_encode($nameErr); ?>, pass, "usernameX");
    changeBorderPassX(<?php echo json_encode($emailErr); ?>, pass, "emailX");
    changeBorderPassX(<?php echo json_encode($pswdErr . $pswdErr2); ?>, pass, "passwordX");
    changeBorderPassX(<?php echo json_encode($fnameErr . $lnameErr); ?>, pass, "nameX");
    /*exception for phone*/
    if (document.getElementById("phone").value !== '') {
        changeBorderErr(<?php echo json_encode($phoneErr); ?>, "phone");
        changeBorderPass(<?php echo json_encode($phoneErr); ?>, pass, "phone");
        changeBorderPassX(<?php echo json_encode($phoneErr); ?>, pass, "phoneX");
    }
</script>
</body>
</html>