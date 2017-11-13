<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/overall.css">
    <link rel="stylesheet" href="../css/loginSystemStyle.css">
    <script src="../js/overall.js"></script>
</head>
<body>
<?php include "../inc/signin_check_inc.php" ?>
<div class="panel">
    <div class="nav"><a href="signUp.php">new user?</a></div>
    <h1>Sign In</h1>
    <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="container-fluid">
            <!--username-->
            <div class="row">
                <div class="col-sm-7"><input type="text" name="userName" id="username"
                                             placeholder="type user's name or email" value="<?= $username ?>"
                        <?php if ($errorFirstLocation == "username") { ?> autofocus <?php } ?>>
                </div>
                <div class="col-sm-5"><span class="error" id="usernameX">* <?php echo $nameErr; ?></span></div>
            </div>
            <!--password-->
            <div class="row">
                <div class="col-sm-7"><input type="password" name="password" id="password" placeholder="password"
                                             value="<?= $pswd ?>"
                        <?php if ($errorFirstLocation == "password") { ?> autofocus <?php } ?>></div>
                <div class="col-sm-5"><span class="error" id="passwordX">* <?php echo $pswdErr; ?></span></div>
            </div>
            <!--submit, remember-->
            <div class="row">
                <div class="col-sm-7"><input type="submit" value="Log in" class="submit"></div>
                <div class="col-sm-5"><span class="remember"><label><input type="checkbox" name="remember"
                                                                           value="yes"><span
                                    class="remember-text"></span></label></span></div>
            </div>
        </div>
    </form>
</div>
<!--scripts-->
<script>
    /*error*/
    changeBorderErr(<?php echo json_encode($nameErr); ?>, "username");
    changeBorderErr(<?php echo json_encode($pswdErr); ?>, "password");
    /*pass*/
    var pass = false;
    pass = <?php echo json_encode($_SERVER["REQUEST_METHOD"] == "POST"); ?>;
    changeBorderPass(<?php echo json_encode($nameErr); ?>, pass, "username");
    changeBorderPass(<?php echo json_encode($pswdErr); ?>, pass, "password");

    changeBorderPassX(<?php echo json_encode($nameErr); ?>, pass, "usernameX");
    changeBorderPassX(<?php echo json_encode($pswdErr); ?>, pass, "passwordX");
</script>
</body>
</html>