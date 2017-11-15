<?php include "studentHeader.php"; ?>
<title>Settings</title>
<link rel="stylesheet" href="../css/settings.css">
<script src="../js/overall.js"></script>
<script>
    /*refresh page when 2 minute no response*/
    refresh(120, function () {
        location.reload();
    });
    textareaEnterSubmit("#address", "form");
</script>
<h1 style="float:left">Settings</h1>
<br>
<h2>Information</h2>
<hr>
<?php include "../inc/updateInfo_inc.php" ?>
<div class="container-fluid align-left">
    <!--UserName-->
    <div class="row">
        <div class="col-sm-3 title">
            <span>Username:</span>
        </div>
        <div class="col-sm-5">
            <input type="text" value="<?php echo $pq['username'] ?>"
                   disabled>
        </div>
        <div class="col-sm-4">
        </div>
    </div>
    <hr>
    <!--full name-->
    <div class="row">
        <div class="col-sm-3 title">
            <span>Fullname:</span></div>
        <div class="col-sm-5">
            <input type="text" value="<?php echo $pq['fname'] . ' ' . $pq['lname'] ?>"
                   disabled>
        </div>
        <div class="col-sm-4">
        </div>
    </div>
    <hr>
    <!--email-->
    <div class="row">
        <div class="col-sm-3 title">
            <span>Email:</span></div>
        <div class="col-sm-5"><input type="text" value="<?php echo $pq['email'] ?>"
                                     disabled>
        </div>

        <div class="col-sm-4">
            <a class="update" href="https://www.google.com">* Update</a>
        </div>
    </div>
    <hr>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" id="form" method="post">
        <!--phone-->
        <div class="row">
            <div class="col-sm-3 title">
                <span>Phone:</span></div>
            <div class="col-sm-5">
                <input type="text" name="phone" id="phone" value="<?php echo $phone ?>"
                       placeholder="Type your phone number here"
                       onkeyup='keyUpEvent(<?php echo json_encode($pq["phone"]) ?>,"phone","phoneX","form",30)'
                       onblur='submitForm(<?php echo json_encode($pq["phone"]) ?>,"phone","form", <?php echo json_encode($phoneErr) ?>)'>
            </div>
            <div class="col-sm-4">
                <span class="correct" id="phoneX">* <?php echo $phoneErr ?></span>
            </div>
        </div>
        <hr>
        <!--address-->
        <div class="row">
            <div class="col-sm-3 title">
                <span>Address:</span></div>
            <div class="col-sm-5">
                        <textarea placeholder="Please type address here" name="address"
                                  id="address"
                                  onkeyup='keyUpEvent(<?php echo json_encode($pq["address"]) ?>,"address","addressX","form",70)'
                                  onblur='submitForm(<?php echo json_encode($pq["address"]) ?>,"address","form","")'><?php echo $address ?></textarea>
            </div>
            <div class="col-sm-4">
                <span class="correct" id="addressX">*</span>
            </div>
        </div>
    </form>
</div>
<h2>Privacy</h2>
<hr>
<div class="container-fluid align-left">
    <!--Password-->
    <div class="row">
        <div class="col-sm-3 title">
            <span>Password:</span>
        </div>
        <div class="col-sm-5">
            <input type="text" value="<?php echo '[md5] ' . substr($pq['password'], 0, 9) . '...' ?>"
                   disabled style="color:lightgray; font-style: italic;">
        </div>
        <div class="col-sm-4">
            <a class="update" href="https://www.google.com">* Change</a>
        </div>
    </div>
</div>
<script>
    //    /*double click to edit*/
    //    dbclkedit("#phone");
    //    dbclkedit("#address");
    redWhenErr(<?php echo json_encode($phoneErr) ?>, 'phoneX');
    changeBorderErr(<?php echo json_encode($phoneErr)?>, 'phone');
</script>
<?php include "studentFooter.php"; ?>
