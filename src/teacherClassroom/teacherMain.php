<?php include "teacherHeader.php"; ?>
<link rel="stylesheet" href="../css/couseMaster.css">
<title>My Classroom</title>
<h1>Welcome Professor <?php echo ucwords($pq['fname']) . " " . ucwords($pq['lname']); ?>!</h1>
<h2>Announcement</h2>
<hr class="hr">
<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
    standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
    type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
    Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of
    Lorem Ipsum.</p>
<h2>My Courses</h2>
<hr class="hr">
<a class="advance" href="manageCourse.php?menu=0">Manage Course</a>
<script src="../js/overall.js"></script>
<script>
    /*refresh page when 1 minute no response*/
    refresh(60, function () {
        location.reload();
    });
</script>
<?php
/*load php functions*/
require_once "../inc/courseUtil.php";
$coursecls = new courseUtil();

/*connect database*/
if (!isset($p)) {
    include "../inc/connect_inc.php";
}

try {
    /*prepare semester*/
    $today = date("Y-m-d");
    /*extent 20 days to enter system*/
    $endSemesterControl = date('Y-m-d', strtotime("-20 days", strtotime($today)));
    $semester = mysqli_fetch_assoc(mysqli_query($db, "SELECT id FROM semester WHERE end > '$endSemesterControl' AND start<'$today'"));
    if (!$semester) {
        throw new Exception($db->error);
    }
    $semester = $semester['id'];
    /*find my class*/
    $myID = $pq['id'];
    $myClass = mysqli_query($db, "SELECT * FROM course WHERE teacher_id=$myID");
    if (!$myClass) {
        throw new Exception($db->error);
    }
    if (mysqli_num_rows($myClass) > 0) {
        while ($rows = mysqli_fetch_assoc($myClass)) {
            /*find is this in semester today*/
            $course_id = $rows['id'];
            $check4ThisSemester = mysqli_query($db, "SELECT * FROM semcourse WHERE course_id=$course_id AND semester_id=$semester");
            if (!$check4ThisSemester) {
                throw new Exception($db->error);
            }
            if (mysqli_num_rows($check4ThisSemester) > 0) {
                $row = mysqli_fetch_assoc($check4ThisSemester);
                if (!$row) {
                    throw new Exception($db->error);
                }
                ?>
                <br>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-7 csdetail">
                            <a class="course"
                               href="../errorPage/featureConstruction.php">
                                <?php
                                /*print course name*/
                                echo $rows['cname'];
                                ?>
                            </a>
                            <br>
                            <span class="coursedetail">
                                    <?php
                                    /*print course week and time*/
                                    echo $coursecls->str2week($row['week']) . "|";
                                    echo $coursecls->shortenTime($row['cstart']) . " ~ " . $coursecls->shortenTime($row['cend']) . "|";
                                    /*print office*/
                                    echo $row['room'];
                                    echo '<br>';
                                    ?>
                        </span>
                        </div>
                        <div class="col-sm-5">
                            <span>N/A</span>
                        </div>
                    </div>
                </div>
            <?php }
        }
    } else { ?>
        <!--no class chosed-->
        <span class="results noresult">No Course Available...</span>
        <?php
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
} ?>

<?php include "teacherFooter.php"; ?>
