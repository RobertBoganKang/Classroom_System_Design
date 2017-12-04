<?php include "teacherHeaderClassroom.php";
include "../mdlib/Parsedown.php";
$mdcls = new Parsedown();
//include "../inc/courseUtil.php";
//$coursecls = new courseUtil();
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
            <!--add course without category-->
            <form action="uploadFile.php" method="post" id="addCourseForm0">
                <input type="hidden" value="<?= $course_id ?>" name="course_id">
                <div class="classroomSidebarList classroomSidebarAdd">
                    <span style="color:green;cursor: pointer"
                          onclick="document.getElementById('addCourseForm0').submit()">+ Add</span>
                </div>
            </form>
        </div>
    </div>
<?php
try {
    /*check teacher has this course for safety*/
    $checkCourse = mysqli_query($db, "SELECT * FROM course WHERE teacher_id=$myID AND id=$course_id");
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
        <?php include "teacherHeaderPartClassroom.php" ?>
        <br>
        <div>
            <!--title-->
            <h1><?= $this_course['cname'] . " (Upload)" ?></h1>
            <title><?= $this_course['cname'] ?></title>
            <!--add content with category-->
            <form action="uploadFile.php" method="post" id="addCourseForm1">
                <input type="hidden" value="<?= $course_id ?>" name="course_id">
                <input type="hidden" value="<?= $category ?>" name="menu">
                <div>
                    <span style="color:green;float:right;cursor: pointer;font-style: italic"
                          onclick="document.getElementById('addCourseForm1').submit()">+ Add</span>
                </div>
            </form>
            <hr>
            <br>
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
                        <?php if ($rowContent['format'] == 'md') { ?>
                            <div class="classContent"><?= $mdcls->parse($myContent) ?></div>
                            <?php
                        } elseif ($rowContent['format'] == 'html') { ?>
                            <div class="classContent">
                                <iframe src="<?= $myFileDIR ?>"></iframe>
                            </div>
                        <?php } elseif ($rowContent['format'] == 'mp3' || $rowContent['format'] == 'ogg') { ?>
                            <div class="classContent">
                                <audio controls>
                                    <source src="<?= $myFileDIR ?>" type="audio/ogg">
                                    <source src="<?= $myFileDIR ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        <?php } elseif ($rowContent['format'] == 'jpg' || $rowContent['format'] == 'png' || $rowContent['format'] == 'jpeg' || $rowContent['format'] == 'gif') { ?>
                            <div class="classContent">
                                <img src="<?= $myFileDIR ?>" alt="<?= $rowContent['filename'] ?>">
                            </div>
                        <?php } elseif ($rowContent['format'] == 'mp4') { ?>
                            <div class="classContent">
                                <video width="320" height="240" controls>
                                    <source src="<?= $myFileDIR ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php } else { ?>
                            <a href="<?= $myFileDIR ?>" target="_blank"
                               download="<?= $rowContent['filename'] . '.' . $rowContent['format'] ?>">Download...</a>
                        <?php } ?>
                    <?php }
                } else { ?>
                    <!--Information-->
                    <h2>Announcement</h2>
                    <hr class="hr">
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
<?php include "teacherFooter.php"; ?>