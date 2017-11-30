<?php include "studentHeaderNoSetting.php"; ?>
<title>Select Semester</title>
<script src="../js/overall.js"></script>
<link rel="stylesheet" href="../css/couseSearch.css">
<h1 style="display: block; float:left">Select Semester</h1>
<br>
<div>
    <?php
    try {
        /*load php functions*/
        require_once "../inc/courseUtil.php";
        $coursecls = new courseUtil();

        /*print semester information*/
        $today = date("Y-m-d");
        $endingdate = date('Y-m-d', strtotime("+6 months", strtotime($today)));
        $seminfo = mysqli_query($db, "SELECT * FROM semester WHERE end > '$today' AND start < '$endingdate';");
        if (!$seminfo) {
            throw new Exception($db->error);
        }
        /*print results*/
        $i = 0;
        while ($row = mysqli_fetch_assoc($seminfo)) { ?>
            <div class="container-fluid searchrow">
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-11">
                        <form action="<?= $_SERVER['PHP_SELF'] . '/../selectCourse.php' ?>" id="form<?= $i ?>"
                              method="get">
                            <input type="hidden" name="new" value="1">
                            <h2 style="cursor: pointer" onclick='document.cookie = "semester=<?= $row['id'] ?>; path=/;";document.getElementById("form<?= $i ?>").submit();'>
                                <?= $row['year'] . ' ' . $coursecls->semester2str($row['type']) ?>
                            </h2>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="hr">
            <div class="container-fluid searchrow">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="title">Starting Date:</p>
                    </div>
                    <div class="col-sm-8">
                        <span class="coursedetail"><?= $row['start'] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <span class="title">Ending Date:</span>
                    </div>
                    <div class="col-sm-8">
                        <span class="coursedetail"><?= $row['end'] ?></span>
                    </div>
                </div>
                <hr>
            </div>
            <?php
            $i++;
        }
    } catch (Exception $e) {
        require_once "../errorPage/errorPageFunc.php";
        $cls = new errorPageFunc();
        $cls->sendErrMsg($e->getMessage());
    }
    ?>
</div>
<?php include "studentFooter.php"; ?>
