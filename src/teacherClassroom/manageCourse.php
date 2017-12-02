<?php include "teacherHeaderNoSetting.php"; ?>
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

        /*prepare semester information*/
        $today = date("Y-m-d");
        $endingdate = date('Y-m-d', strtotime("+1 year", strtotime($today)));
        $seminfo = mysqli_query($db, "SELECT * FROM semester WHERE start > '$today' AND end < '$endingdate';");
        if (!$seminfo) {
            throw new Exception($db->error);
        }

        /*prepare course information*/
        if (isset($_GET['semester'])) {
            $myID = $pq['id'];
            $myCourse = mysqli_query($db, "SELECT * FROM course WHERE teacher_id=$myID");
            if (!$myCourse) {
                throw new Exception($db->error);
            }
        }
        ?>
        <br>
        <div>
            <!--Open course-->
            <div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="menu0">
                    <input type="hidden" value="0" name="menu">
                    <h2 style="cursor: pointer" onclick="document.getElementById('menu0').submit()">Open</h2>
                </form>
                <hr>
                <?php if (isset($_GET['menu']) && $_GET['menu'] == 0) {
                    $i = 0;
                    while ($rowSemester = mysqli_fetch_assoc($seminfo)) {
                        ?>
                        <div>
                            <!--select semester-->
                            <form action="<?= $_SERVER['PHP_SELF'] ?>"
                                  id="form<?= $i ?>"
                                  method="get">
                                <input type="hidden" name="menu" value="0">
                                <input type="hidden" name="semester" value="<?= $rowSemester['id'] ?>">
                                <h3 style="cursor: pointer; text-align: right"
                                    <?php
                                    /*when not selected, dim the title*/
                                    if (isset($_GET['semester']) && $_GET['semester'] != $rowSemester['id']) { ?>
                                        class="h3inactive"
                                    <?php } ?>
                                    onclick='document.cookie = "semester=<?= $rowSemester['id'] ?>; path=/;";document.getElementById("form<?= $i ?>").submit();'>
                                    <?= $rowSemester['year'] . ' ' . $coursecls->semester2str($rowSemester['type']) ?>
                                </h3>
                            </form>

                            <?php if (isset($_GET['semester']) && $_GET['semester'] == $rowSemester['id']) {
                                $semester = $_GET['semester'];
                                /*count the course*/
                                $countOpenCourse = 0;
                                while ($rowCourse = mysqli_fetch_assoc($myCourse)) {
                                    $course_id = $rowCourse['id'];
                                    $checkOpenStatusq = mysqli_query($db, "SELECT * FROM semcourse WHERE course_id=$course_id AND semester_id=$semester");
                                    if (!$checkOpenStatusq) {
                                        throw new Exception($db->error);
                                    }
                                    $checkOpenStatus = mysqli_num_rows($checkOpenStatusq);
                                    /*not opened, show it here*/
                                    if ($checkOpenStatus < 1) {
                                        $countOpenCourse++; ?>
                                        <div class="container-fluid searchrow">
                                            <div class="row">
                                                <div class="col-sm-7 csdetail">
                                                    <span class="course"><?= $rowCourse['cname'] ?></span>
                                                </div>

                                                <?php if (!isset($_GET['course']) || isset($_GET['course']) && $_GET['course'] != $rowCourse['id']) { ?>
                                                    <!--if not activate to open tab-->
                                                    <div class="col-sm-5">
                                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                                                              onclick="document.getElementById('courseForm<?= $course_id ?>').submit();"
                                                              id="courseForm<?= $course_id ?>"
                                                              method="get" <?php if (!isset($_GET['course']) || isset($_GET['course']) && $_GET['course'] != $rowCourse['id']) {
                                                            ?> class="openCourseButton" <?php
                                                        } else {
                                                            ?> style="color:red;padding:15px"<?php
                                                        } ?>>
                                                            <input type="hidden" name="menu" value="0">
                                                            <input type="hidden" name="semester"
                                                                   value="<?= $rowSemester['id'] ?>">
                                                            <input type="hidden" name="course"
                                                                   value="<?= $course_id ?>">
                                                            <span> * </span>
                                                        </form>
                                                    </div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <!--if activate to open tab-->
                                                    <div class="col-sm-5" style="padding:15px">
                                                        <span style="color:red" id="submitOpenCourse0"> ... </span>
                                                        <span style="color:red;display:none;border:1px red solid;cursor: pointer;"
                                                              id="submitOpenCourse1"
                                                              onclick="document.getElementById('courseOpenForm').submit()"> Open </span>
                                                    </div>
                                                    <?php
                                                } ?>
                                            </div>
                                            <hr>
                                            <?php if (isset($_GET['course']) && $_GET['course'] == $rowCourse['id']) {
                                                /*get all filled info*/
                                                $advCstart = $advCend = $advRoom = $advWeek = "";
                                                if (isset($_GET['advCstart'])) {
                                                    $advCstart = $_GET['advCstart'];
                                                }
                                                if (isset($_GET['advCend'])) {
                                                    $advCend = $_GET['advCend'];
                                                }
                                                if (isset($_GET['advRoom'])) {
                                                    $advRoom = $_GET['advRoom'];
                                                }
                                                if (isset($_GET['advWeek'])) {
                                                    $advWeek = $_GET['advWeek'];
                                                }

                                                ?>
                                                <!--form of open course-->
                                                <form action="openCourse.php" method="get" id="courseOpenForm"
                                                      onclick="ckbx2arr(['advWeek0', 'advWeek1', 'advWeek2', 'advWeek3', 'advWeek4', 'advWeek5', 'advWeek6'], 'advWeek');
if(document.getElementById('advWeek').value!=='' && document.getElementById('advStart').value!=='' && document.getElementById('advEnd').value!==''&&document.getElementById('officeText').value!==''&&document.getElementById('advEnd').value>document.getElementById('advStart').value){
    document.getElementById('submitOpenCourse0').style.display='none'; document.getElementById('submitOpenCourse1').style.display='inline';
} else {
    document.getElementById('submitOpenCourse0').style.display='inline'; document.getElementById('submitOpenCourse1').style.display='none';
}" onkeyup="if(document.getElementById('advWeek').value!=='' && document.getElementById('advStart').value!=='' && document.getElementById('advEnd').value!==''&&document.getElementById('officeText').value!==''&&document.getElementById('advEnd').value>document.getElementById('advStart').value){
    document.getElementById('submitOpenCourse0').style.display='none'; document.getElementById('submitOpenCourse1').style.display='inline';
} else {
    document.getElementById('submitOpenCourse0').style.display='inline'; document.getElementById('submitOpenCourse1').style.display='none';
}">
                                                    <!--week filter-->
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <span class="title">Week: </span>
                                                        </div>
                                                        <div class="col-sm-9 navbar">
                                                            [<span id="advWeek0"
                                                                   class="ckbx<?= $coursecls->ckbxColor('advWeek', '0') ?>"
                                                                   onclick="changeColor('advWeek0')">Su</span>
                                                            | <span id="advWeek1"
                                                                    class="ckbx<?= $coursecls->ckbxColor('advWeek', '1') ?>"
                                                                    onclick="changeColor('advWeek1')">Mo</span>
                                                            | <span id="advWeek2"
                                                                    class="ckbx<?= $coursecls->ckbxColor('advWeek', '2') ?>"
                                                                    onclick="changeColor('advWeek2')">Tu</span>
                                                            | <span id="advWeek3"
                                                                    class="ckbx<?= $coursecls->ckbxColor('advWeek', '3') ?>"
                                                                    onclick="changeColor('advWeek3')">We</span>
                                                            | <span id="advWeek4"
                                                                    class="ckbx<?= $coursecls->ckbxColor('advWeek', '4') ?>"
                                                                    onclick="changeColor('advWeek4')">Th</span>
                                                            | <span id="advWeek5"
                                                                    class="ckbx<?= $coursecls->ckbxColor('advWeek', '5') ?>"
                                                                    onclick="changeColor('advWeek5')">Fr</span>
                                                            | <span id="advWeek6"
                                                                    class="ckbx<?= $coursecls->ckbxColor('advWeek', '6') ?>"
                                                                    onclick="changeColor('advWeek6')">Sa</span>]
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!--start and end time-->
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <span class="title">Time: </span>
                                                        </div>
                                                        <!--starting time-->
                                                        <div class="col-sm-5">
                            <span class="greaterthan">start
                                <input type="time" name="advStart" id="advStart"
                                       value="<?= htmlspecialchars($advCstart) ?>">
                            </span>
                                                        </div>
                                                        <!--ending time-->
                                                        <div class="col-sm-4">
                            <span class="lessthan">end
                                <input type="time" name="advEnd" id="advEnd" value="<?= htmlspecialchars($advCend) ?>">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!--Office-->
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <span class="title">Office: </span>
                                                        </div>
                                                        <div class="col-sm-9">
                                                        <textarea name="office" rows="1" id="officeText"
                                                                  placeholder="Type Office information..."><?= $advRoom ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php if (isset($_SESSION['checkcourseErr'])) { ?>
                                                        <!--Violence Error Message-->
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <span class="results noresult"><?= $_SESSION['checkcourseErr'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        unset($_SESSION['checkcourseErr']);
                                                    } ?>
                                                    <!--real body-->
                                                    <input type="hidden" name="advWeek" id="advWeek">
                                                    <input type="hidden" name="semester"
                                                           value="<?= $rowSemester['id'] ?>">
                                                    <input type="hidden" name="course"
                                                           value="<?= $course_id ?>">
                                                </form>
                                                <hr>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                }
                                if ($countOpenCourse < 1) {
                                    ?>
                                    <span class="results noresult">You have opened every available course for this semester...</span>
                                    <?php
                                }
                            } ?>
                        </div>
                        <?php
                        $i++;
                    }
                } ?>
            </div>

            <!--close course-->
            <div id="dropCourseTab">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="menu1">
                    <input type="hidden" value="1" name="menu">
                    <h2 style="cursor: pointer" onclick="document.getElementById('menu1').submit()">Close</h2>
                </form>
                <hr>
                <?php if (isset($_GET['menu']) && $_GET['menu'] == 1) {
                    $i = 0;
                    while ($rowSemester = mysqli_fetch_assoc($seminfo)) {
                        ?>
                        <div>
                            <!--select semester-->
                            <form action="<?= $_SERVER['PHP_SELF'] ?>"
                                  id="form<?= $i ?>"
                                  method="get">
                                <input type="hidden" name="menu" value="1">
                                <input type="hidden" name="semester" value="<?= $rowSemester['id'] ?>">
                                <h3 style="cursor: pointer; text-align: right"
                                    <?php
                                    /*when not selected, dim the title*/
                                    if (isset($_GET['semester']) && $_GET['semester'] != $rowSemester['id']) { ?>
                                        class="h3inactive"
                                    <?php } ?>
                                    onclick='document.cookie = "semester=<?= $rowSemester['id'] ?>; path=/;";document.getElementById("form<?= $i ?>").submit();'>
                                    <?= $rowSemester['year'] . ' ' . $coursecls->semester2str($rowSemester['type']) ?>
                                </h3>
                            </form>

                            <?php if (isset($_GET['semester']) && $_GET['semester'] == $rowSemester['id']) {
                                $semester = $_GET['semester'];
                                /*count the course*/
                                $countCloseCourse = 0;
                                while ($rowCourse = mysqli_fetch_assoc($myCourse)) {
                                    $course_id = $rowCourse['id'];
                                    $checkCloseStatusq = mysqli_query($db, "SELECT * FROM semcourse WHERE course_id=$course_id AND semester_id=$semester");
                                    if (!$checkCloseStatusq) {
                                        throw new Exception($db->error);
                                    }
                                    $checkCloseStatus = mysqli_num_rows($checkCloseStatusq);
                                    /*if opened, show it here to close*/
                                    if ($checkCloseStatus > 0) {
                                        $countCloseCourse++; ?>
                                        <div class="container-fluid searchrow">
                                            <div class="row">
                                                <div class="col-sm-7 csdetail">
                                                    <span class="course"><?= $rowCourse['cname'] ?></span>
                                                </div>
                                                <!--close course button-->
                                                <div class="col-sm-5" style="padding:15px">
                                                    <span id="courseClose<?= $course_id ?>" class="closeCourseButton"
                                                          onclick="document.getElementById('courseClose<?= $course_id ?>').style.display='none';
                                                                  document.getElementById('courseClose<?= $course_id ?>').classList.remove('closeCourseButton');
                                                                  document.getElementById('courseClose<?= $course_id ?>').classList.add('closeCourseButton0');
                                                                  document.getElementById('courseCloseConfirm<?= $course_id ?>').style.display='inline';
                                                                  setTimeout(function(){
                                                                  document.getElementById('courseClose<?= $course_id ?>').style.display='inline';
                                                                  document.getElementById('courseClose<?= $course_id ?>').classList.add('closeCourseButton');
                                                                  document.getElementById('courseClose<?= $course_id ?>').classList.remove('closeCourseButton0');
                                                                  document.getElementById('courseCloseConfirm<?= $course_id ?>').style.display='none';
                                                                  }, 5000);
                                                                  "> * </span>
                                                    <a id="courseCloseConfirm<?= $course_id ?>"
                                                       href="closeCourse.php?course=<?= $course_id ?>&semester=<?= $semester ?>"
                                                       class="closeCourseButton0" style="display:none">* Confirm</a>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    <?php }
                                }
                                if ($countCloseCourse < 1) {
                                    ?>
                                    <span class="results noresult">No course has been opened for this semester...</span>
                                    <?php
                                }
                            } ?>
                        </div>
                        <?php
                        $i++;
                    }
                } ?>
            </div>

            <!--create course-->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="menu2">
                <input type="hidden" value="2" name="menu">
                <h2 style="cursor: pointer" onclick="document.getElementById('menu2').submit()">Create</h2>
            </form>
            <?php if (isset($_GET['menu']) && $_GET['menu'] == 2) {
                echo "hello2";
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
<?php include "teacherFooter.php"; ?>
