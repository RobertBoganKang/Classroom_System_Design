<?php include "studentHeader.php"; ?>
<title>Add Courses</title>
<script src="../js/overall.js"></script>
<link rel="stylesheet" href="../css/couseSearch.css">
<h1 style="display: block; float:left">Select Course</h1>
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
        setcookie('semester', 1, null, '/');
        $semester = $_COOKIE['semester'];
        $seminfo = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM semester WHERE id = $semester;"));
        if (!$seminfo) {
            throw new Exception($db->error);
        }
        ?>
        <br>
        <div class="container-fluid searchrow">
            <div class="row">
                <div class="col-sm-7">
                    <form action="#">
                        <input type="text" placeholder="Type to search..." class="searchinput" autofocus>
                    </form>
                </div>
                <div class="col-sm-5">
                    <h2>
                        <?= $seminfo['year'] . ' ' . $coursecls->semester2str($seminfo['type']) ?>
                    </h2>
                </div>
            </div>
        </div>
        <hr class="hr">

        <?php
        /*count how many course available*/
        /** wrong*/
        $count = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS count FROM addcourse WHERE semester_id = $semester;"));
        if (!$count) {
            throw new Exception($db->error);
        }
        /*if no result, please show something else*/
        if ($count['count'] > 0) {
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

            $semclsq = mysqli_query($db, "SELECT * FROM addcourse WHERE semester_id =$semester ORDER BY id DESC LIMIT $limit OFFSET $offset;");
            if (!$semclsq) {
                throw new Exception($db->error);
            }
            /**test area*/
            /*UI continue*/
            while ($row = mysqli_fetch_assoc($semclsq)) {
                ?>
                <div class="container-fluid csdetail">
                    <div class="row">
                        <div class="col-sm-9">
                            <a class="course" href="../errorPage/featureConstruction.html">
                                <?php
                                /*print course name*/
                                echo $row['cname'];
                                ?>
                            </a>
                            <br>
                            <span class="coursedetail">
                                    <?php
                                    /*print course week and time*/
                                    echo $coursecls->str2week($row['week']) . "|";
                                    echo $coursecls->shortenTime($row['cstart']) . " ~ " . $coursecls->shortenTime($row['cend']) . "|";
                                    /*print teacher name*/
                                    echo $row['tfname'] . ' ' . $row['tlname'];
                                    echo '<br>';
                                    ?>
                                </span>
                        </div>
                        <!--stars ranking-->
                        <div class="col-sm-3">
                            <!--rating details-->
                            <span class="stars<?= round((int)$row['rating']) ?> ratingdetails">
                                <?= bcdiv($row['rating'] * 10, 10, 1) ?>
                            </span>
                            <!--color stars-->
                            <span class="stars<?= round((int)$row['rating']) ?>">
                                <?= $coursecls->starStr((int)$row['rating']) ?>
                            </span>
                            <!--gray stars-->
                            <span style="color:#eee">
                                <?= $coursecls->starStr(5 - (int)$row['rating']) ?>
                            </span>
                            <!--popularity-->
                            <span class="popularity"><?= $row['nrating'] ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!--show result-->
            <div class="results"><?= $count['count'] ?> result(s) available</div>
            <hr>
            <?php if ($maxpage > 1) { ?>
                <!--jump page-->
                <span>
            <!--jump page by number-->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET"
                  id="form" class="form">
        <input type="number" name="page" id="page" value="<?= $page; ?>" min="1" max="<?= $maxpage ?>"
               onblur="submitForm(<?= $_GET['page'] ?>, 'page', 'form', 0)" class="jump">
        </form>
        <span class="navbar">
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
            </span>
        </span>
            <?php }
        } else { ?>
            <div class="results noresult">No result available</div>
        <?php } ?>
        <?php
    } catch (Exception $e) {
        require_once "../errorPage/errorPageFunc.php";
        $cls = new errorPageFunc();
        $cls->sendErrMsg($e->getMessage());
    }
    ?>
</div>
<?php include "studentFooter.php"; ?>
