<?php include "studentHeaderNoSetting.php"; ?>
<title>Course Master</title>
<script src="../js/overall.js"></script>
<link rel="stylesheet" href="../css/couseMaster.css">
<h1 style="display: block; float:left">Manage Course</h1>
<br>
<div>
    <?php
    try {
        /*load php functions*/
        require_once "../inc/courseUtil.php";
        $coursecls = new courseUtil();
        if (isset($_GET['menu']) && $_GET['menu'] < 2) {
            $today = date("Y-m-d");
            $endingdate = date('Y-m-d', strtotime("+6 months", strtotime($today)));
            $seminfo = mysqli_query($db, "SELECT * FROM semester WHERE end > '$today' AND start < '$endingdate';");
            if (!$seminfo) {
                throw new Exception($db->error);
            }
        }
        ?>
        <br>
        <div>
            <!--add course-->
            <div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="menu0">
                    <input type="hidden" value="0" name="menu">
                    <h2 style="cursor: pointer" onclick="document.getElementById('menu0').submit()">Add</h2>
                </form>
                <hr>
                <?php
                if (isset($_GET['menu']) && $_GET['menu'] == 0) {
                    /*print results*/
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($seminfo)) { ?>
                        <div>
                            <form action="<?= $_SERVER['PHP_SELF'] . '/../selectCourse.php' ?>"
                                  id="form<?= $i ?>"
                                  method="get">
                                <input type="hidden" name="new" value="1">
                                <h3 style="cursor: pointer; text-align: right"
                                    onclick='document.cookie = "semester=<?= $row['id'] ?>; path=/;";document.getElementById("form<?= $i ?>").submit();'>
                                    <?= $row['year'] . ' ' . $coursecls->semester2str($row['type']) ?>
                                </h3>
                            </form>
                        </div>
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
                        </div>
                        <?php
                        $i++;
                    }
                } ?>
            </div>

            <!--drop course-->
            <div id="dropCourseTab">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="menu1">
                    <input type="hidden" value="1" name="menu">
                    <h2 style="cursor: pointer" onclick="document.getElementById('menu1').submit()">Drop</h2>
                </form>
                <hr>
                <?php if (isset($_GET['menu']) && $_GET['menu'] == 1) {
                    ?>
                    <div>
                        <?php
                        /*count dropable classes*/
                        $dropcount = 0;
                        while ($rowdrop = mysqli_fetch_assoc($seminfo)) {
                            $semester = $rowdrop['id'];
                            /*find my class*/
                            $myID = $pq['id'];
                            $myClass = mysqli_query($db, "SELECT * FROM stucourse WHERE student_id=$myID AND semester_id=$semester AND NOT (grade = 'W' OR grade = 'O')");
                            if (!$myClass) {
                                throw new Exception($db->error);
                            }
                            /*accumulate dropable course for deleting the tab when no result*/
                            $dropcount += mysqli_num_rows($myClass);
                            /*if semester has course*/
                            if (mysqli_num_rows($myClass) > 0) {
                                /*warning message*/
                                $endingdate1Month = date('Y-m-d', strtotime("+30 days", strtotime($rowdrop['start'])));
                                $endingdatedrop = date('Y-m-d', strtotime("+10 days", strtotime($rowdrop['start'])));
                                ?>
                                <h3><?= $rowdrop['year'] . ' ' . $coursecls->semester2str($rowdrop['type']) ?></h3>
                                <?php
                                /*set state 0: good to drop;
                                 *1: could drop (payment features is not here, payment table also affected 15%);
                                 *2: drop course with 'W' grade*/
                                $state = 0;
                                /*partly payment*/
                                if ($today > $endingdatedrop && $today < $endingdate1Month) {
                                    $state = 1;
                                    ?>
                                    <span class="results noresult"
                                          style="line-height: 120%">Warning: you have passing the last day (<?= $endingdatedrop ?>
                                        ) of dropping the course. Since it is within one month of trial of course, you will be paid at 15% of tuition of dropping each course.
                        </span>
                                    <?php
                                }
                                /*more than one month, receive W in grade*/
                                if ($today >= $endingdate1Month) {
                                    $state = 2;
                                    ?>
                                    <span class="results noresult" style="line-height: 120%">Warning: since you have passing the last day
                                (<?= $endingdatedrop ?>) of dropping the course.
                        You will receive 'W' in your grade. This grade will not affect overall GPA, however your tuition will not be refunded.</span>
                                    <?php
                                }

                                /*course information*/
                                while ($rows = mysqli_fetch_assoc($myClass)) {
                                    /*find what's this course*/
                                    $course_id = $rows['course_id'];
                                    $row = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM addcourse WHERE course_id=$course_id AND semester_id=$semester"));
                                    if (!$row) {
                                        throw new Exception($db->error);
                                    }
                                    ?>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-9 csdetail">
                                            <span class="course">
                                                <?php
                                                /*print course name*/
                                                echo $row['cname'];
                                                ?>
                                            </span>
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
                                            <div class="col-sm-3" style="padding: 15px; cursor: pointer;">
                                                <!--write a funny javascript-->
                                                <span class="classdrop" id="classdrop<?= $course_id ?>"
                                                      onclick="document.getElementById('classdrop<?= $course_id ?>').style.display='none';
                                                              document.getElementById('classdropconfirm<?= $course_id ?>').style.display='inline';
                                                              setTimeout(function(){document.getElementById('classdropconfirm<?= $course_id ?>').innerHTML='No?'},5000);
                                                              setTimeout(function(){document.getElementById('classdrop<?= $course_id ?>').style.display='inline';
                                                              document.getElementById('classdropconfirm<?= $course_id ?>').style.display='none';
                                                              document.getElementById('classdropconfirm<?= $course_id ?>').innerHTML='Drop?';},8000
                                                              )">Drop</span>
                                                <a class="classchooseconfirm" style="color: orangered"
                                                   id="classdropconfirm<?= $course_id ?>"
                                                   href="dropClass.php?state=<?= $state ?>&course_id=<?= $course_id ?>&student_id=<?= $myID ?>">
                                                    Goodbye?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                }
                            }
                        }
                        /*if no result, delete this tab*/
                        if ($dropcount < 1) {
                            ?>
                            <span class="results">No available courses to drop...</span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } ?>
            </div>

            <!--check grades-->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="menu2">
                <input type="hidden" value="2" name="menu">
                <h2 style="cursor: pointer" onclick="document.getElementById('menu2').submit()">Grade</h2>
            </form>
            <?php if (isset($_GET['menu']) && $_GET['menu'] == 2) {
                $myID = $pq['id'];
                $findMyGrade = mysqli_query($db, "SELECT * FROM stucourse WHERE student_id=$myID AND grade<>'O' AND grade<>'' ORDER BY semester_id");
                if (!$findMyGrade) {
                    throw new Exception($db->error);
                }
                if (mysqli_num_rows($findMyGrade) < 0) { ?>
                    <span class="results noresult">No grade available...</span>
                <?php } else {
                    $myGPA = $numberOfCourse = 0;
                    ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 title">Course</div>
                            <div class="col-sm-3 title">Semester</div>
                            <div class="col-sm-3 title">Grade</div>
                        </div>
                        <hr>
                        <?php while ($rowGrade = mysqli_fetch_assoc($findMyGrade)) {
                            /*calculate GPA*/
                            $courseGrade = $coursecls->gradStr2Num($rowGrade['grade']);
                            if ($courseGrade > 0) {
                                $myGPA += $courseGrade;
                                $numberOfCourse++;
                            }
                            /*find information to print*/
                            $myCourseID = $rowGrade['course_id'];
                            $mySemesterID = $rowGrade['semester_id'];
                            $findMyCourse = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM course WHERE id=$myCourseID"));
                            if (!$findMyCourse) {
                                throw new Exception($db->error);
                            }
                            $findMySemester = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM semester WHERE id=$mySemesterID"));
                            if (!$findMySemester) {
                                throw new Exception($db->error);
                            }
                            $courseName = $findMyCourse['cname'];
                            $courseSemester = $findMySemester['year'] . " " . $coursecls->semester2str($findMySemester['type']);
                            /*print information*/
                            ?>
                            <div class="row">
                                <div class="col-sm-6"><?= $courseName ?></div>
                                <div class="col-sm-3"><?= $courseSemester ?></div>
                                <div class="col-sm-3"><?= $rowGrade['grade'] ?></div>
                            </div>
                            <hr>
                            <?php
                        } ?>
                        <?php
                        /*calculate GPA*/
                        if ($numberOfCourse != 0) {
                            $myGPA /= $numberOfCourse;
                        } else {
                            $myGPA = 0;
                        }
                        $myGPA = number_format((float)$myGPA, 2, '.', '');
                        /*print GPA*/
                        ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-9">
                                    <span class="title" style="font-size:50px">My GPA:</span>
                                </div>
                                <div class="col-sm-3">
                                        <span style="font-size:50px;font-weight:100;color:<?php if ($myGPA > 3.5) {
                                            echo 'green';
                                        } elseif ($myGPA > 3.5) {
                                            echo 'darkorange';
                                        } elseif ($myGPA > 3) {
                                            echo 'yellowgreen';
                                        } elseif ($myGPA > 2.5) {
                                            echo 'orange';
                                        } elseif ($myGPA > 2) {
                                            echo 'orangered';
                                        } elseif ($myGPA > 1) {
                                            echo 'red';
                                        } else {
                                            echo 'lightgray';
                                        } ?>"><?php if ($myGPA < 1) {
                                                echo 'N/A';
                                            } else {
                                                echo $myGPA;
                                            } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } ?>
        </div>
        <?php

    } catch (Exception $e) {
        require_once "../errorPage/errorPageFunc.php";
        $cls = new errorPageFunc();
        $cls->sendErrMsg($e->getMessage());
    }
    ?>
</div>
<?php include "studentFooter.php"; ?>
