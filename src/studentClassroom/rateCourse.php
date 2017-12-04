<?php include "studentHeaderClassroom.php";
try {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    require_once "../inc/courseUtil.php";
    $coursecls = new courseUtil();
    $myID = $pq['id'];
    /*get comments*/
    /*limit comment numbers*/
    /**not implemented*/
    $limit = 300;
    $myRatings = mysqli_query($db, "SELECT * FROM stucourse WHERE course_id=$course_id AND student_id=$myID");
    if (!$myRatings) {
        throw new Exception($db->error);
    }
    if (mysqli_num_rows($myRatings) > 0) {
        $rating = mysqli_fetch_assoc($myRatings);
        $myRating = $rating['rating'];
        $myComment = $rating['comment'];
    } else {
        $myRating = 0;
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
}
?>
    <script src="../js/overall.js"></script>
    <script src="../js/starSystem.js"></script>
    <link rel="stylesheet" href="../css/couseMaster.css">
    <link rel="stylesheet" href="../css/starSystems.css">

    <div class="panel">
        <?php include "studentHeaderPartClassroom.php"; ?>
        <!--remove left side bar-->
        <script>document.getElementById('navl').style.display = 'none'</script>
        <br>
        <div>
            <!--title-->
            <h1><?= $course_name . " (Rate)" ?></h1>
            <title><?= $course_name ?></title>
            <!--my rating-->
            <h2>My Rating</h2>
            <hr class="hr">
            <form action="studentRatingHelper.php" id="ratingForm" method="post"
                  onclick='document.getElementById("submitRating").style.display="inline"'
                  onsubmit="document.getElementById('rating').value=remember">
                <input type="submit" id="submitRating" class="hiddenSubmit" value="submit">
                <div><?= $coursecls->starManualRating($myRating); ?></div>
                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                <input type="hidden" name="student_id" value="<?= $myID ?>">
                <input type="hidden" name="rating" id="rating">
                <textarea name="comment" id="comment" cols="30" rows="3"
                          placeholder="Type your comment here..."><?= $myComment ?></textarea>
            </form>
            <!--comments section-->
            <h2>Other Ratings</h2>
            <hr class="hr">
            <?php
            try {
                $course = mysqli_fetch_assoc(mysqli_query($db, "SELECT rating, nrating FROM course WHERE id=$course_id"));
                if (!$course) {
                    throw new Exception($db->error);
                }
                ?>
                <!--overall star rating-->
                <span class="commentstars"><?= $coursecls->starRating($course['rating']) ?></span>
                <br>
                <?php
                /*limit comment numbers*/
                /**not implemented*/
                $limit = 300;
                $comments = mysqli_query($db, "SELECT * FROM stucourse WHERE course_id=$course_id AND student_id<>$myID AND rating<>0 ORDER BY id DESC LIMIT $limit");
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
                            $student_id = $row['student_id'];
                            if ($row['rating'] != null) {
                                /*find student information*/
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
                        }
                        ?>
                    </div>
                    <?php
                }
            } catch (Exception $e) {
                require_once "../errorPage/errorPageFunc.php";
                $cls = new errorPageFunc();
                $cls->sendErrMsg($e->getMessage());
            } ?>
        </div>
    </div>

<?php include "studentFooter.php"; ?>