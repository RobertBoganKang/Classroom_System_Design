<?php include "studentHeader.php"; ?>
    <script src="../js/overall.js"></script>
    <link rel="stylesheet" href="../css/couseSearch.css">
    <link rel="stylesheet" href="../css/starSystems.css">
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

            /*semester information*/
            $semester = $_COOKIE['semester'];

            /*check information and get course info*/
            $scID = $_GET['scID'];
            $cID = $_GET['cID'];
            $course = mysqli_query($db, "SELECT * FROM addcourse WHERE semester_id=$semester AND semcourse_id=$scID AND course_id=$cID");
            if (mysqli_num_rows($course) < 1) {
                throw new Exception("Cookies and URL incorrect! Please do not change mannully");
            }
            /*get course information*/
            $courseinfo = mysqli_fetch_assoc($course);

            /*prepare class select button*/
            $Myid = $pq['id'];
            /*prepare error message*/
            $checkcourseErr = "";
            /*check chose class status*/
            $checkcourse = mysqli_query($db, "SELECT * FROM stucourse WHERE student_id=$Myid AND course_id=$cID");
            if (!$checkcourse) {
                throw new Exception($db->error);
            }
            if (mysqli_num_rows($checkcourse) > 0) {
                $coursestatus = mysqli_fetch_assoc($checkcourse);
                if ($coursestatus['semester_id'] == $semester) {
                    $checkcourseErr = "You have already chosed for this semester";
                } else {
                    $checkcourseErr = "You have chosed this course previously";
                }
            }
            /*check time overlap for this semester*/
            $checkcourse = mysqli_query($db, "SELECT * FROM stucourse WHERE student_id=$Myid AND semester_id=$semester");
            if (!$checkcourse) {
                throw new Exception($db->error);
            }
            if (mysqli_num_rows($checkcourse) > 0) {
                $courseweekarr = str_split($courseinfo['week']);
                while ($row = mysqli_fetch_assoc($checkcourse)) {
                    if ($checkcourseErr != "") break;
                    $courseidcheck = $row['course_id'];
                    $findchosedcourseq = mysqli_query($db, "SELECT * FROM addcourse WHERE course_id=$courseidcheck AND semester_id=$semester");
                    $findchosedcourse = mysqli_fetch_assoc($findchosedcourseq);
                    if (!$findchosedcourse) {
                        throw new Exception($db->error);
                    }
                    foreach ($courseweekarr as $week) {
                        /*find if week has matched*/
                        if (strpos($findchosedcourse['week'], $week) != -1) {
                            /*find time interval has overlap*/
                            if (($findchosedcourse['cstart'] > $courseinfo['cstart'] && $findchosedcourse['cstart'] < $courseinfo['cend']) ||
                                ($findchosedcourse['cend'] > $courseinfo['cstart'] && $findchosedcourse['cend'] < $courseinfo['cend'])) {
                                $checkcourseErr = "[" . $findchosedcourse['cname'] . "] took up the time for this course";
                                break;
                            }
                        }
                    }
                }
            }
            ?>
            <title><?= $courseinfo['cname'] ?></title>
            <h1>Course Details</h1>
            <h2><?= $courseinfo['cname'] ?></h2>
            <hr class="hr">
            <p style="font-style: italic; color: #aaa;text-align: right;"><?= $courseinfo['cdetail'] ?></p>
            <!--            <h2>Information</h2>-->
            <div class="container-fluid">
                <!--course id-->
                <div class="row">
                    <div class="col-sm-3">
                        <span class="title">#:</span>
                    </div>
                    <div class="col-sm-9 coursedetail">
                        <span>(<?= $courseinfo['course_id'] ?>)</span>
                    </div>
                </div>
                <hr>
                <!--course name-->
                <div class="row">
                    <div class="col-sm-3">
                        <span class="title">Name:</span>
                    </div>
                    <div class="col-sm-9 coursedetail">
                        <span><?= $courseinfo['cname'] ?></span>
                    </div>
                </div>
                <hr>
                <!--Time-->
                <div class="row">
                    <div class="col-sm-3">
                        <span class="title">Time:</span>
                    </div>
                    <div class="col-sm-9 coursedetail">
                        <span>
                            <?php echo $coursecls->shortenTime($courseinfo['cstart']) . " ~ " . $coursecls->shortenTime($courseinfo['cend']) . " @ ";
                            echo $coursecls->fullstr2week($courseinfo['week']); ?>
                        </span>
                    </div>
                </div>
                <hr>
                <!--Teacher Name-->
                <div class="row">
                    <div class="col-sm-3">
                        <span class="title">Teacher:</span>
                    </div>
                    <div class="col-sm-9 coursedetail">
                        <a href="teacherProfile.php?tid=<?= $courseinfo['tid'] ?>">
                            <?= $courseinfo['tfname'] . ' ' . $courseinfo['tlname']; ?>
                        </a>
                    </div>
                </div>
                <hr>
                <!--Classroom-->
                <div class="row">
                    <div class="col-sm-3">
                        <span class="title">Classroom:</span>
                    </div>
                    <div class="col-sm-9 coursedetail">
                        <span>
                            <?= $courseinfo['room']; ?>
                        </span>
                    </div>
                </div>
                <hr>
                <!--button to choose course-->
                <?php if ($checkcourseErr != "") { ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="../errorPage/featureConstruction.php" style="color:red;font-weight:700;">Error:</a>
                        </div>
                        <div class="col-sm-9 coursedetail">
                            <span class="results noresult">* <?= $checkcourseErr ?></span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="../errorPage/featureConstruction.php" class="classchoose">Choose</a>
                        </div>
                        <div class="col-sm-9 coursedetail">
                            <span style="color:green">*</span>
                        </div>
                    </div>
                    <?php
                } ?>

            </div>
            <!--comments section-->
            <h2>Comments</h2>
            <hr class="hr">
            <!--overall star rating-->
            <span class="commentstars"><?= $coursecls->starRating($courseinfo['rating']) ?></span>
            <?php
            /*limit comment numbers*/
            /**not implemented*/
            $limit = 300;
            $comments = mysqli_query($db, "SELECT * FROM stucourse WHERE course_id=$cID ORDER BY id DESC LIMIT $limit");
            if (!$comments) {
                throw new Exception($db->error);
            }
            if (mysqli_num_rows($comments) < 1) {
                ?>
                <!--no comments-->
                <div class="results noresult">No comments available...</div>
                <?php
            } else { ?>
                <div class="container-fluid" style="font-style: italic">
                <?php
                $i = 0;
                while ($row = mysqli_fetch_assoc($comments)) {
                    if ($row['rating'] != null) {
                        /*find student information*/
                        $student_id = $row['student_id'];
                        $student = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM student WHERE id=$student_id"));
                        if (!$student) {
                            throw new Exception($db->error);
                        }
                        $stusem = $row['semester_id'];
                        $stusemester = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM semester WHERE id=$stusem"));
                        if (!$stusemester) {
                            throw new Exception($db->error);
                        }
                        /*print out comments*/
                        ?>
                        <div class="row" style="font-style: italic">
                            <div class="col-sm-7">
                                <span class="title"><?= ucwords($student['fname']) . ' ' . ucwords($student['lname']) ?></span>
                                <span class="commentUsername">@<?= $student['username'] ?></span>
                                <br>
                                <span class="comments"><?= $row['comment'] ?></span>
                            </div>
                            <div class="col-sm-5">
                                <span class="advance2"><?= $stusemester['year'] . ' ' . $coursecls->semester2str($stusemester['type']) ?></span>
                                <span>
                                    <?= $coursecls->starRating($row['rating']) ?>
                                </span>
                            </div>
                        </div>
                        <?php
                        $i++;
                        if ($i < mysqli_num_rows($comments)) {
                            ?>
                            <hr>
                            <?php
                        }
                    }
                    ?>
                    </div>
                    <?php
                }
            }
        } catch (Exception $e) {
            require_once "../errorPage/errorPageFunc.php";
            $cls = new errorPageFunc();
            $cls->sendErrMsg($e->getMessage());
        }
        ?>
    </div>
<?php include "studentFooter.php"; ?>