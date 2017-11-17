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
        require_once "../inc/stringUtils.php";
        $coursecls = new courseUtil();
        $stringcls = new stringUtils();

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
        /*set get values*/
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            /*trim search input*/
            $search = $stringcls->trimText($search);
        } else {
            $search = "";
        }
        ?>
        <br>
        <!--search engine-->
        <div class="container-fluid searchrow">
            <div class="row">
                <div class="col-sm-7">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" id="formsearch" method="GET">
                        <input type="hidden" name="page" value="<?= $page ?>">
                        <input type="text" name="search" id="search" placeholder="Type to search..." class="searchinput"
                               value="<?= $search ?>" autofocus
                               onblur='submitForm0(<?= json_encode($search) ?>, "search", "formsearch")'>
                    </form>
                </div>
                <div class="col-sm-5">
                    <h2><?= $seminfo['year'] . ' ' . $coursecls->semester2str($seminfo['type']) ?></h2>
                </div>
            </div>
        </div>
        <hr class="hr">

        <?php
        /*search engine sql builder*/
        $searchSQLbuilder = '';
        $searcharr = array_unique(preg_split('/\s+/', $search));
        if ($search != '') {
            $searchSQLbuilder .= " ";
            for ($i = 0; $i < count($searcharr); $i++) {
                $searchSQLbuilder .= " AND (cname LIKE '%$searcharr[$i]%' OR cdetail LIKE '%$searcharr[$i]%' OR tfname LIKE '%$searcharr[$i]%' OR tlname LIKE '%$searcharr[$i]%')";
            }
            $searchSQLbuilder .= " ";
        }

        /*count how many course available*/
        $count = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS count FROM addcourse WHERE semester_id = $semester" . $searchSQLbuilder . ";"));
        if (!$count) {
            throw new Exception($db->error);
        }
        /*if no result, please show something else*/
        if ($count['count'] > 0) {
            /*how many result on one page*/
            $limit = 3;
            /*maximum page*/
            $maxpage = intdiv((int)$count['count'] + $limit - 1, $limit);
            if ($page < 1) {
                $page = 1;
            }
            if ($page > $maxpage) {
                $page = $maxpage;
            }
            $offset = ($page - 1) * $limit;

            $semclsq = mysqli_query($db, "SELECT * FROM addcourse WHERE semester_id =$semester " . $searchSQLbuilder . " ORDER BY id DESC LIMIT $limit OFFSET $offset;");
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
                            <span class="popularity">(<?= $row['nrating'] ?>)</span>
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
                <input type="hidden" name="search" value="<?= $search ?>">
        <input type="number" name="page" id="page" value="<?= $page; ?>" min="1" max="<?= $maxpage ?>"
               onblur="submitForm0(<?= $page ?>, 'page', 'form')" class="jump">
        </form>
        <span class="navbar">
                [
            <!--first page-->
            <?php if ($page != 1) { ?>
                <a class="jumpPage"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=1' . '&search=' . $search) ?>">#</a>
            <?php } ?>
            <!--previous page-->
            <?php if ($page != 1) { ?>
                | <a class="jumpPage"
                     href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($page - 1) . '&search=' . $search) ?>">&lt&lt</a>
            <?php } ?>
            <!--next page-->
            <?php
            if ($page != 1 && $page != $maxpage) {
                echo "|";
            }
            if ($page != $maxpage) { ?>
                <a class="jumpPage"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($page + 1) . '&search=' . $search) ?>">&gt&gt</a>
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
