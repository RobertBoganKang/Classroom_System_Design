<?php include "studentHeaderClassroom.php";
include "../mdlib/Parsedown.php";
$mdcls = new Parsedown();
include "../inc/courseUtil.php";
$coursecls = new courseUtil();
?>
    <script src="../js/overall.js"></script>
    <script src="../js/starSystem.js"></script>
    <link rel="stylesheet" href="../css/couseMaster.css">
    <link rel="stylesheet" href="../css/starSystems.css">
    <link rel="stylesheet" href="../mdlib/prism.css">
    <script src="../mdlib/prism.js"></script>
<?php
try {
    /*find Category*/
    $myID = $pq['id'];
    $course_id = $_GET['course_id'];

    /*update reading time*/
    $updateReadingTime = mysqli_query($db, "UPDATE stucourse SET read_time=now() WHERE student_id=$myID AND course_id=$course_id;");

    $sidebarList = mysqli_query($db, "SELECT DISTINCT category FROM t2s WHERE course_id=$course_id");
    if (!$sidebarList) {
        throw new Exception($db->error);
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
} ?>
    <!--sidebar-->
    <div class="classroomSidebar" id="classroomSidebar">
        <div class="classroomSidebarContent">
            <div class="classroomSidebarList classroomSidebarClose"
                 onclick="document.getElementById('classroomSidebar').style.display = 'none';">[X] close
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" id="informationForm">
                <input type="hidden" name="course_id" value="<?= $course_id ?>">
                <div onclick="document.getElementById('informationForm').submit()"
                     class="classroomSidebarList<?php if (!isset($_GET['menu'])) echo "1" ?>">Information
                </div>
            </form>
            <?php while ($rowSidebar = mysqli_fetch_assoc($sidebarList)) {
                $category = $rowSidebar['category']; ?>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" id="<?= $rowSidebar['category'] ?>"
                      method="get">
                    <input type="hidden" name="menu" value="<?= $category ?>">
                    <input type="hidden" name="course_id" value="<?= $course_id ?>">
                    <div onclick="document.getElementById('<?= $category ?>').submit()"
                         class="classroomSidebarList<?php if (isset($_GET['menu']) && $_GET['menu'] == $rowSidebar['category']) echo "1" ?>"><?= $rowSidebar['category'] ?></div>
                </form>
                <?php
            } ?>
        </div>
    </div>
<?php
try {
    /*check student has this course for safety*/
    $checkCourse = mysqli_query($db, "SELECT * FROM stucourse WHERE student_id=$myID AND course_id=$course_id");
    if (!$checkCourse) {
        throw new Exception($db->error);
    }
    if (mysqli_num_rows($checkCourse) < 1) {
        throw new Exception("Please fix your url to the classroom");
    }
    /*prepare course*/
    $this_course = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM course WHERE id=$course_id"));
    if (!$this_course) {
        throw new Exception($db->error);
    }

    /*prepare content*/
    if (isset($_GET['menu'])) {
        $category = $_GET['menu'];
        $contentList = mysqli_query($db, "SELECT * FROM t2s WHERE course_id=$course_id AND category='$category'");
        if (!$contentList) {
            throw new Exception($db->error);
        }
    }
} catch (Exception $e) {
    require_once "../errorPage/errorPageFunc.php";
    $cls = new errorPageFunc();
    $cls->sendErrMsg($e->getMessage());
} ?>
    <div class="panel"
         onclick="if(document.getElementById('classroomSidebar').style.display==='block'){document.getElementById('classroomSidebar').style.display = 'none';}">
        <?php include "studentHeaderPartClassroom.php" ?>
        <br>
        <div>
            <!--title-->
            <h1><?= $this_course['cname'] . " (Download)" ?></h1>
            <title><?= $this_course['cname'] ?></title>
            <!--content-->
            <div>
                <?php if (isset($_GET['menu']) && mysqli_num_rows($contentList) > 0) {
                while ($rowContent = mysqli_fetch_assoc($contentList)) {
                    $myFileDIR = '../files/' . $rowContent['id'] . '.' . $rowContent['format'];
                    $myContent = file_get_contents($myFileDIR);
                    ?>
                <br>
                    <h3><?= $rowContent['filename'] . ' (.' . $rowContent['format'] . ")" ?></h3>
                <hr>
                    <div class="classContent">
                        <div class="contentBig" id="content<?= $rowContent['id'] ?>">
                            <?php if ($rowContent['format'] == 'md') {
                                echo $mdcls->parse($myContent);
                            } elseif ($rowContent['format'] == 'html' || $rowContent['format'] == 'htm') { ?>
                                <iframe src="<?= $myFileDIR ?>"></iframe>
                            <?php } elseif ($rowContent['format'] == 'mp3' || $rowContent['format'] == 'ogg') { ?>
                                <audio controls>
                                    <source src="<?= $myFileDIR ?>" type="audio/ogg">
                                    <source src="<?= $myFileDIR ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            <?php } elseif ($rowContent['format'] == 'jpg' || $rowContent['format'] == 'png'
                                || $rowContent['format'] == 'jpeg' || $rowContent['format'] == 'gif'
                                || $rowContent['format'] == 'svg' || $rowContent['format'] == 'bmp') { ?>
                                <img src="<?= $myFileDIR ?>" alt="<?= $rowContent['filename'] ?>">
                            <?php } elseif ($rowContent['format'] == 'mp4') { ?>
                                <video width="320" height="240" controls>
                                    <source src="<?= $myFileDIR ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php } else { ?>
                                <a href="<?= $myFileDIR ?>" target="_blank"
                                   download="<?= $rowContent['filename'] . '.' . $rowContent['format'] ?>">Download...</a>
                            <?php } ?>
                        </div>
                        <a href="#" id="contentLink<?= $rowContent['id'] ?>">Read more...</a>
                    </div>
                    <script>
                        if ($('#content<?= $rowContent["id"] ?>').height() < 500) {
                            document.getElementById('contentLink<?= $rowContent["id"] ?>').style.display = "none";
                        } else {
                            document.getElementById('content<?= $rowContent["id"] ?>').className = "contentSmall";
                        }
                    </script>
                <?php }
                } else { ?>
                    <!--Information-->
                    <h2>Announcement</h2>
                <hr class="hr">
                    <form action="rateCourse.php" method="post" id="rateForm">
                        <input type="hidden" name="course_id" value="<?= $course_id ?>">
                        <input type="hidden" name="course_name" value="<?= $this_course['cname'] ?>">
                        <span onclick="document.getElementById('rateForm').submit()" class="advance2">Rate</span>
                    </form>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of
                        Lorem Ipsum.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!--read more-->
    <script>
        $('.classContent').find('a[href="#"]').on('click', function (e) {
            e.preventDefault();
            this.expand = !this.expand;
            $(this).text(this.expand ? "Read less..." : "Read more...");
            $(this).closest('.classContent').find('.contentSmall, .contentBig').toggleClass('contentSmall contentBig');
        });
    </script>
<?php include "studentFooterClassroom.php"; ?>