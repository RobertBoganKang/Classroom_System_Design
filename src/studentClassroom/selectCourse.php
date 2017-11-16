<?php include "studentHeader.php"; ?>
<title>Add Courses</title>
<script src="../js/overall.js"></script>
<link rel="stylesheet" href="../css/couseSearch.css">
<h1 style="display: block; float:left">Select Course</h1>
<br>
<br>
<div>
    <?php

    try {
        /*load php functions*/
        require_once "../inc/courseUtil.php";
        $coursecls = new courseUtil();

        /*if not connect in the header file, connect database*/
        if (!isset($p)) {
            /*connect database*/
            include "../inc/connect_inc.php";
        }

        /*print semester information*/
        /**test area*/
        $semester = 1;
        $seminfo = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM semester WHERE id = $semester;"));
        if (!$seminfo) {
            throw new Exception($db->error);
        }
        ?>
        <h2>
            <?= $seminfo['year'] . ' ' . $coursecls->semester2str($seminfo['type']) ?>
        </h2>
        <hr>

        <?php


        /*count how many course available*/
        $count = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS count FROM semcourse WHERE semester_id = $semester;"));
        if (!$count) {
            throw new Exception($db->error);
        }
        /*how many result on one page*/
        $limit = 3;
        /*get page number*/
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        /*maximum page*/
        $maxpage = intdiv((int)$count['count'] + $limit - 1, $limit);
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $maxpage) {
            $page = $maxpage;
        }
        $offset = ($page - 1) * $limit;

        $semclsq = mysqli_query($db, "SELECT * FROM semcourse WHERE semester_id =$semester ORDER BY id DESC LIMIT $limit OFFSET $offset;");
        if (!$semclsq) {
            throw new Exception($db->error);
        }
        while ($row = mysqli_fetch_assoc($semclsq)) {
            /*find course details*/
            $id = $row['course_id'];
            $assocourse = mysqli_fetch_assoc(mysqli_query($db, "SELECT name, teacher_id FROM course WHERE id='$id';"));
            $id = $assocourse['teacher_id'];
            $assocteacher = mysqli_fetch_assoc(mysqli_query($db, "SELECT fname, lname FROM teacher WHERE id='$id';"));
            ?>
            <div class="container-fluid align-left csdetail">
                <div class="row">
                    <div class="col-sm-10">
                        <a class="course" href="../errorPage/featureConstruction.html">
                            <?php
                            /*print course name*/
                            echo $assocourse['name'];
                            ?>
                        </a>
                        <br>
                        <span class="coursedetail">
                                    <?php
                                    /*print course week and time*/
                                    echo $coursecls->str2week($row['week']) . "|";
                                    echo $coursecls->shortenTime($row['start']) . " ~ " . $coursecls->shortenTime($row['end']) . "|";
                                    /*print teacher name*/
                                    echo $assocteacher['fname'] . ' ' . $assocteacher['lname'];
                                    echo '<br>';
                                    ?>
                                </span>
                    </div>
                    <!--stars ranking feature is currently unavailable-->
                    <div class="col-sm-2 stars4">*</div>
                </div>
            </div>
            <?php
        }
        ?>
        <hr>
        <span>
            <!--jump page-->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET"
                  id="form" class="form">
                <input type="number" name="page" id="page" value="<?= $page; ?>" min="1" max="<?= $maxpage ?>"
                       onblur="submitForm(<?= $_GET['page'] ?>, 'page', 'form', 0)" class="jump">
            </form>
            <span style="color: lightgray">
                [
                <!--first page-->
                <?php if ($page != 1) { ?>
                    <a class="jumpPage" href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=1') ?>">#</a>
                <?php } ?>
                <!--previous page-->
                <?php if ($page != 1) { ?>
                    | <a class="jumpPage"
                         href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($page - 1)) ?>">&lt&lt</a>
                <?php } ?>
                <!--next page-->
                <?php
                if ($page != 1 && $page != $maxpage) {
                    echo "|";
                }
                if ($page != $maxpage) { ?>
                    <a class="jumpPage"
                       href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($page + 1)) ?>">&gt&gt</a>
                <?php } ?>
                ]
            </span style="color: lightgray">
        </span>
        <?php
    } catch (Exception $e) {
        require_once "../errorPage/errorPageFunc.php";
        $cls = new errorPageFunc();
        $cls->sendErrMsg($e->getMessage());
    }
    ?>
</div>
<?php include "studentFooter.php"; ?>
