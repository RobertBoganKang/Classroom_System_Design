<?php include "teacherHeaderNoSetting.php";
if (isset($_POST['course_id'])) {
    unset($_SESSION['menu']);
    unset($_SESSION['course_id']);
    unset($_SESSION['file_id']);
    $course_id = $_POST['course_id'];
}
if (isset($_POST['menu'])) {
    $category = $_POST['menu'];
}
if (isset($_POST['file_id'])) {
    $file_id = $_POST['file_id'];
}
if (isset($_SESSION['course_id'])) {
    $course_id = $_SESSION['course_id'];
}
if (isset($_SESSION['menu'])) {
    $category = $_SESSION['menu'];
}
if (isset($_SESSION['file_id'])) {
    $file_id = $_SESSION['file_id'];
}
?>
    <script src="../js/overall.js"></script>
    <script src="../js/starSystem.js"></script>
    <link rel="stylesheet" href="../css/couseMaster.css">
    <link rel="stylesheet" href="../css/starSystems.css">

    <div>
        <!--title-->
        <h1>Update Files...</h1>
        <title>Update Files</title>
        <!--remove left side bar-->
        <script>document.getElementById('navl').style.display = 'none'</script>
        <form action="updateFileHelper.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <input type="hidden" name="file_id" value="<?= $file_id ?>">
            <input type="hidden" name="menu" value="<?= $category ?>">
            <br><input type="file" name="updateFile" style="margin: 5px">
            <br><input type="submit" value="submit" style="margin: 5px">
        </form>
        <?php if (isset($_SESSION['updateErr'])) { ?>
            <span class="results noresult"><?= $_SESSION['updateErr'] ?></span>
        <?php }
        unset($_SESSION['updateErr']); ?>
    </div>
<?php include "teacherFooter.php"; ?>