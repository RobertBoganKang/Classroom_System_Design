<?php include "studentHeader.php"; ?>
<title>My Classroom</title>
<link rel="stylesheet" href="../css/couseSearch.css">
<h1>Welcome <?php echo ucwords($pq['fname']) . " " . ucwords($pq['lname']); ?>!</h1>
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
<a class="advance" href="selectSemester.php">Add Course</a>
<?php
/*load php functions*/
require_once "../inc/courseUtil.php";
$coursecls = new courseUtil();

/*connect database*/
if (!isset($p)) {
    include "../inc/connect_inc.php";
}

/*prepare semester*/
$today = date("Y-m-d");
//echo $today;
$semester = mysqli_fetch_assoc(mysqli_query($db, "SELECT id FROM semester WHERE end > '$today' AND start<'$today'"));
$semester = $semester['id'];
/*find my class*/
$myID = $pq['id'];
$myClass = mysqli_query($db, "SELECT * FROM stucourse WHERE student_id=$myID AND semester_id=$semester");
if (mysqli_num_rows($myClass) > 0) {
    while ($rows = mysqli_fetch_assoc($myClass)) {
        /*find what's this course*/
        $course_id = $rows['course_id'];
        $row = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM addcourse WHERE course_id=$course_id AND semester_id=$semester"));
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-7 csdetail">
                    <a class="course"
                       href="../errorPage/featureConstruction.php?scID=<?= $row['semcourse_id'] ?>&cID=<?= $row['course_id'] ?>">
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
                <div class="col-sm-5">
                    <span>N/A</span>
                </div>
            </div>
        </div>
        <?
    }
} else { ?>
    <!--no class chosed-->
    <span class="results noresult">No Course Available...</span>
    <?php
}


?>

<?php include "studentFooter.php"; ?>
