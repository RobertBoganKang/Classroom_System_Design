<?php include "teacherHeader.php"; ?>
<title>Settings</title>
<link rel="stylesheet" href="../css/settings.css">
<script src="../js/overall.js"></script>
<style>
    @import url(http://fonts.googleapis.com/css?family=Homemade+Apple:400,100,100italic,300,300ita‌​lic,400italic,500,500italic,700,700italic,900italic,900);
</style>
<script>
    /*refresh page when 2 minute no response*/
    refresh(120, function () {
        location.reload();
    });
    textareaEnterSubmit("#address", "form");
</script>
<?php include "../inc/updateInfo_inc.php" ?>
<h1 style="float:left">Settings</h1>
<br><br>
<!--Information-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?content=' . $_GET['content']) ?>" method="GET"
      id="form0">
    <input type="hidden" name="content" value="0">
    <h2 onclick="document.getElementById('form0').submit()">Information</h2>
</form>
<hr>
<?php if ($_GET['content'] == 0) { ?>
    <div class="container-fluid">
        <!--Id-->
        <div class="row">
            <div class="col-sm-3 title">
                <span>#:</span>
            </div>
            <div class="col-sm-5">
                <?php echo $pq['id'] ?>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <hr>
        <!--UserName-->
        <div class="row">
            <div class="col-sm-3 title">
                <span>Username:</span>
            </div>
            <div class="col-sm-5">
                <?php echo $pq['username'] ?>
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
                <?php echo $pq['fname'] . ' ' . $pq['lname'] ?>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <hr>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?content=' . $_GET['content']) ?>" id="form"
              method="post">
            <!--office-->
            <div class="row">
                <div class="col-sm-3 title">
                    <span>Office:</span></div>
                <div class="col-sm-5">
                    <input type="text" name="office" id="office" value="<?php echo $office ?>"
                           placeholder="Type your phone number here"
                           onkeyup='keyUpEvent(<?php echo json_encode($pq["office"]) ?>,"office","officeX","form",30)'
                           onblur='submitForm(<?php echo json_encode($pq["office"]) ?>,"office","form", <?php echo json_encode($phoneErr) ?>)'>
                </div>
                <div class="col-sm-4">
                    <span class="correct" id="officeX">* <?php echo $officeErr ?></span>
                </div>
            </div>
            <hr>
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
<?php } ?>

<!--privacy-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET" id="form1">
    <input type="hidden" name="content" value="1">
    <h2 onclick="document.getElementById('form1').submit()">Privacy</h2>
</form>
<hr>
<?php if ($_GET['content'] == 1) { ?>
    <div class="container-fluid">
        <!--email-->
        <div class="row">
            <div class="col-sm-3 title">
                <span>Email:</span></div>
            <div class="col-sm-5">
                <?php echo $pq['email'] ?>
            </div>
            <div class="col-sm-4">
                <a class="update" href="../errorPage/featureConstruction.php"></a>
            </div>
        </div>
        <hr>
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
                <a class="update" href="../errorPage/featureConstruction.php"></a>
            </div>
        </div>
    </div>
<?php } ?>
<!--style-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET" id="form2">
    <input type="hidden" name="content" value="2">
    <h2 onclick="document.getElementById('form2').submit()">Style</h2>
</form>
<?php if ($_GET['content'] == 2) { ?>
    <hr>
    <div class="container-fluid">
        <!--style-->
        <div class="row">
            <div class="col-sm-3 title">
                <span style="">Style:</span></div>
            <div class="col-sm-3">
                <p onclick="document.cookie='style=0;path=/';location.reload();"
                   style="color: dimgray; font-family: 'Open Sans' , sans-serif;">
                    Plain</p>
            </div>
            <div class="col-sm-3">
                <p onclick="document.cookie='style=1;path=/';location.reload();"
                   style="color: green; font-family: 'Homemade Apple' , sans-serif;">
                    Fun</p>
            </div>
            <div class="col-sm-3">
                <p onclick="document.cookie='style=2;path=/';location.reload();"
                   style="color: red; font-family: 'Times New Roman' , sans-serif;">
                    Nude</p>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    redWhenErr(<?php echo json_encode($phoneErr) ?>, 'phoneX');
    redWhenErr(<?php echo json_encode($officeErr) ?>, 'officeX');
    changeBorderErr(<?php echo json_encode($phoneErr)?>, 'phone');
    changeBorderErr(<?php echo json_encode($officeErr)?>, 'office');
</script>
<?php include "teacherFooter.php"; ?>
