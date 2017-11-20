<?php include "studentHeader.php"; ?>
<title>Add Courses</title>
<script src="../js/overall.js"></script>
<link rel="stylesheet" href="../css/couseSearch.css">
<link rel="stylesheet" href="../css/starSystems.css">
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
        $searchURL = "&search=" . $search;

        /*advanced search functions*/
        $advTest = (!isset($_GET['advType']) || !isset($_GET['advWeek']) || !isset($_GET['advFilter']) || !isset($_GET['advLess']) || !isset($_GET['advGreater']));
        if ($advTest) {
            /*0: course name; 1: course detail; 2: teacher name*/
            /*translate to ' AND (cname LIKE '%$var%' OR cdetail LIKE '%$var%' OR tfname LIKE '%$var%' OR tlname LIKE '%$var%')'*/
            $advType = "012";
            /*0 ~ 6 is Sunday ~ Saturday*/
            $advWeek = "";
            /*time filter*/
            $advLess = "";
            $advGreater = "";
            /*0: name; 1: rating; 2: popularity*/
            $advFilter = "0";
            /*variable to show advanced is not available*/
            $adv = 0;
            $advURL = "";
        } else {
            /*advanced feature open*/
            $advType = $_GET['advType'];
            $advWeek = $_GET['advWeek'];
            $advLess = $_GET['advLess'];
            $advGreater = $_GET['advGreater'];
            $advFilter = $_GET['advFilter'];
            $adv = 1;
            $advURL = "&advType=" . $advType . "&advWeek=" . $advWeek . "&advFilter=" . $advFilter . "&advLess=" . $advLess . "&advGreater=" . $advGreater;
        }

        ?>
        <br>
        <!--search engine-->
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" id="formsearch" method="GET"
              onclick="hidden2show('hiddenSubmit');"
              onsubmit="<?php if ($adv) { ?>ckbx2arr(['advType0', 'advType1', 'advType2'], 'advType');
                      ckbx2arr(['advWeek0', 'advWeek1', 'advWeek2', 'advWeek3', 'advWeek4', 'advWeek5', 'advWeek6'], 'advWeek');<?php } ?>">
            <div class="container-fluid searchrow">
                <div class="row">
                    <div class="col-sm-7">
                        <input type="hidden" name="page" value="<?= $page ?>">
                        <input type="text" name="search" id="search" placeholder="Type to search..." class="searchinput"
                               value="<?= $search ?>"
                               onblur='submitForm0(<?= $adv ? json_encode("") : json_encode($search) ?>, "search", "formsearch");'>
                    </div>
                    <div class="col-sm-5">
                        <h2><?= $seminfo['year'] . ' ' . $coursecls->semester2str($seminfo['type']) ?></h2>
                    </div>
                </div>
            </div>
            <hr class="hr">
            <!--advanced ribbon-->
            <?php if (!$adv) { ?>
                <!--non-advanced mode-->
                <a class="advance"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . (string)$page . $searchURL . "&advType=012&advWeek=&advFilter=0&adv=1&advLess=23:59&advGreater=00:00" ?>">advanced</a>
            <?php } else { ?>
                <!--advanced mode-->
                <a class="advance2"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . (string)$page . $searchURL ?>">advanced</a>
                <!--advanced type gather information-->
                <div class="container-fluid advancebox">
                    <!--where to search-->
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="title">Where: </span>
                        </div>
                        <div class="col-sm-9 navbar">
                            [<span id="advType0" style="color:<?= $coursecls->ckbxColor('advType', '0') ?>"
                                   onclick="changeColor('advType0')">Course Name</span>
                            | <span id="advType1" style="color:<?= $coursecls->ckbxColor('advType', '1') ?>"
                                    onclick="changeColor('advType1')">Course Detail</span>
                            |<span id="advType2" style="color:<?= $coursecls->ckbxColor('advType', '2') ?>"
                                   class="ckbx<?= $coursecls->ckbxColor('advType', '2') ?>"
                                   onclick="changeColor('advType2')">Teacher Name</span>]
                        </div>
                    </div>
                    <hr>
                    <!--week filter-->
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="title">Week: </span>
                        </div>
                        <div class="col-sm-9 navbar">
                            [<span id="advWeek0" style="color:<?= $coursecls->ckbxColor('advWeek', '0') ?>"
                                   onclick="changeColor('advWeek0')">Su</span>
                            | <span id="advWeek1" style="color:<?= $coursecls->ckbxColor('advWeek', '1') ?>"
                                    onclick="changeColor('advWeek1')">Mo</span>
                            | <span id="advWeek2" style="color:<?= $coursecls->ckbxColor('advWeek', '2') ?>"
                                    onclick="changeColor('advWeek2')">Tu</span>
                            | <span id="advWeek3" style="color:<?= $coursecls->ckbxColor('advWeek', '3') ?>"
                                    onclick="changeColor('advWeek3')">We</span>
                            | <span id="advWeek4" style="color:<?= $coursecls->ckbxColor('advWeek', '4') ?>"
                                    onclick="changeColor('advWeek4')">Th</span>
                            | <span id="advWeek5" style="color:<?= $coursecls->ckbxColor('advWeek', '5') ?>"
                                    onclick="changeColor('advWeek5')">Fr</span>
                            | <span id="advWeek6" style="color:<?= $coursecls->ckbxColor('advWeek', '6') ?>"
                                    onclick="changeColor('advWeek6')">Sa</span>]
                        </div>
                    </div>
                    <hr>
                    <!--time filter-->
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="title">Time: </span>
                        </div>
                        <!--greater than-->
                        <div class="col-sm-5 navbar">
                            <span>>=
                                <input type="time" name="advGreater" value="<?= htmlspecialchars($advGreater) ?>">
                            </span>
                        </div>
                        <!--less than-->
                        <div class="col-sm-4 navbar">
                            <span><=
                                <input type="time" name="advLess" value="<?= htmlspecialchars($advLess) ?>">
                            </span>
                        </div>
                    </div>
                    <hr>
                    <!--search filter-->
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="title">Rank: </span>
                        </div>
                        <div class="col-sm-6">
                            <select name="advFilter" class="advFilter" id="advFilter"
                                    onchange='<?php if ($adv) { ?>ckbx2arr(["advType0", "advType1", "advType2"], "advType");
                                            ckbx2arr(["advWeek0", "advWeek1", "advWeek2", "advWeek3", "advWeek4", "advWeek5", "advWeek6"], "advWeek");<?php } ?>
                                            this.form.submit();'>
                                <option value="0" <?php if ($_GET['advFilter'] == "0") echo 'selected="selected"' ?>>
                                    Course Name
                                </option>
                                <option value="1" <?php if ($_GET['advFilter'] == "1") echo 'selected="selected"' ?>>
                                    Rating
                                </option>
                                <option value="2" <?php if ($_GET['advFilter'] == "2") echo 'selected="selected"' ?>>
                                    Popularity
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="submit" class="hiddenSubmit" value="Search" id="hiddenSubmit">
                        </div>
                    </div>
                </div>
                <!--advanced search field-->
                <input type="hidden" name="advType" id="advType">
                <input type="hidden" name="advWeek" id="advWeek">
                <hr>
            <?php } ?>
        </form>
        <?php
        /*search engine sql builder*/
        $searchWordSQLbuilder = '';
        $searcharr = array_unique(preg_split('/\s+/', $search));
        if ($search != '') {
            $searchWordSQLbuilder .= " ";
            for ($i = 0; $i < count($searcharr); $i++) {
                $searchWordSQLbuilder .= $coursecls->advType($advType, $searcharr[$i]);
            }
            $searchWordSQLbuilder .= " ";
        }

        /*calculate max popularity*/
        if (!isset($_COOKIE['mxpop'])) {
            $temp = mysqli_fetch_assoc(mysqli_query($db, "SELECT MAX(nrating) AS mxpop FROM course;"));
            $mxpop = $temp['mxpop'];
            setcookie("mxpop", $mxpop);
        } else {
            $mxpop = $_COOKIE['mxpop'];
        }

        /*if flip pages (is set), we don't count*/
        if (!isset($_SESSION['count']) || isset($_GET['new']) || !isset($_GET['f']) || isset($_GET['adv'])) {
            /*count how many course available*/
            $count = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS count FROM addcourse WHERE semester_id = $semester " . $coursecls->advWeek($advWeek) . $coursecls->advTimeFilter($advGreater, $advLess) . $searchWordSQLbuilder . ";"));
            if (!$count) {
                throw new Exception($db->error);
            }
            $_SESSION['count'] = $count['count'];
            $count = $count['count'];
        } else {
            $count = $_SESSION['count'];
        }
        /*if no result, please show something else*/
        if ($count > 0) {
            /*how many result on one page*/
            $limit = 3;
            /*maximum page*/
            $maxpage = intdiv((int)$count + $limit - 1, $limit);
            if ($page < 1) {
                $page = 1;
            }
            if ($page > $maxpage) {
                $page = $maxpage;
            }
            $offset = ($page - 1) * $limit;

            /*search to show*/
            $semclsq = mysqli_query($db, "SELECT * FROM addcourse WHERE semester_id =$semester " . $coursecls->advWeek($advWeek) . $searchWordSQLbuilder . " ORDER BY " . $coursecls->advFilter($advFilter) . " LIMIT $limit OFFSET $offset;");
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
                            <a class="course" href="../errorPage/featureConstruction.php">
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
                                    /*print office*/
                                    echo $row['room'] . "|";
                                    /*print teacher name*/
                                    echo $row['tfname'] . ' ' . $row['tlname'];
                                    echo '<br>';
                                    ?>
                                </span>
                        </div>
                        <!--stars ranking-->
                        <div class="col-sm-3">
                            <!--rating details-->
                            <span id="starslist">
                                <span class="stars<?= round($row['rating']) . '1' ?> ratingdetails"><?= bcdiv($row['rating'] * 10, 10, 1) ?></span>
                                <span class="ratingstars">
                                    <span class="stars<?= round($row['rating']) . "1" ?>">*</span>
                                    <span class="dots<?= round(5 * bcdiv($row['nrating'], $mxpop, 3)) . "1" ?>">_</span>
                                    <span class="stars<?= round($row['rating']) . "2" ?>">*</span>
                                    <span class="dots<?= round(5 * bcdiv($row['nrating'], $mxpop, 3)) . "2" ?>">_</span>
                                    <span class="stars<?= round($row['rating']) . "3" ?>">*</span>
                                    <span class="dots<?= round(5 * bcdiv($row['nrating'], $mxpop, 3)) . "3" ?>">_</span>
                                    <span class="stars<?= round($row['rating']) . "4" ?>">*</span>
                                    <span class="dots<?= round(5 * bcdiv($row['nrating'], $mxpop, 3)) . "4" ?>">_</span>
                                    <span class="stars<?= round($row['rating']) . "5" ?>">*</span>
                                    <span class="dots<?= round(5 * bcdiv($row['nrating'], $mxpop, 3)) . "5" ?>">_</span>
                                </span>
                            </span>
                            <!--popularity-->
                            <span class="popularity dots<?= round(5 * bcdiv($row['nrating'], $mxpop, 3)) . "5" ?>"><?= $row['nrating'] ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!--show result-->
            <div class="results"><?= $count ?> result(s) available</div>
            <hr>
            <?php if ($maxpage > 1) { ?>
                <!--jump page-->
                <span>
            <!--jump page by number-->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET"
                  id="form" class="form">
                <?php if ($adv) {
                    ?>
                    <input type="hidden" name="f" value="1">
                    <input type="hidden" name="advType" id="advType" value="<?= $advType ?>">
                    <input type="hidden" name="advWeek" value="<?= $advWeek ?>">
                    <input type="hidden" name="advFilter" value="<?= $advFilter ?>">
                    <?php
                } ?>
                <input type="hidden" name="search" value="<?= $search ?>">
        <input type="number" name="page" id="page" value="<?= $page; ?>" min="1" max="<?= $maxpage ?>"
               onblur="submitForm0(<?= $page ?>, 'page', 'form')" class="jump">
        </form>
        <span class="navbar">
                [
            <!--first page-->
            <?php if ($page != 1 && $maxpage != 2) { ?>
                <a class="jumpPage"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=1' . $searchURL . $advURL . '&f=1') ?>">#</a>
            <?php }
            if ($page != 1 && $maxpage != 2) {
                echo "|";
            } ?>
            <!--previous page-->
            <?php if ($page != 1) { ?>
                <a class="jumpPage1"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($page - 1) . $searchURL . $advURL . '&f=1') ?>">&lt&lt</a>
            <?php }
            if ($page != 1 && $page != $maxpage) {
                echo "|";
            } ?>
            <!--next page-->
            <?php
            if ($page != $maxpage) { ?>
                <a class="jumpPage2"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($page + 1) . $searchURL . $advURL . '&f=1') ?>">&gt&gt</a>
            <?php }
            if ($page != $maxpage && $maxpage != 2) {
                echo "|";
            }
            if ($page != $maxpage && $maxpage != 2) { ?>
                <a class="jumpPage3"
                   href="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?page=' . (string)($maxpage) . $searchURL . $advURL . '&f=1') ?>">~.</a>
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
