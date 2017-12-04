<?php include "teacherHeaderNoSetting.php";
if (isset($_POST['course_id'])) {
    unset($_SESSION['menu']);
    unset($_SESSION['course_id']);
    $course_id = $_POST['course_id'];
}
if (isset($_POST['menu'])) {
    $category = $_POST['menu'];
}
if (isset($_SESSION['course_id'])) {
    $course_id = $_SESSION['course_id'];
}
if (isset($_SESSION['menu'])) {
    $category = $_SESSION['menu'];
}
?>
    <script src="../js/overall.js"></script>
    <script src="../js/starSystem.js"></script>
    <link rel="stylesheet" href="../css/couseMaster.css">
    <link rel="stylesheet" href="../css/starSystems.css">

    <div>
        <!--title-->
        <h1>Upload Files...</h1>
        <title>Upload Files</title>
        <!--remove left side bar-->
        <script>document.getElementById('navl').style.display = 'none'</script>
        <form action="uploadFileHelper.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <?php if (!isset($category)) { ?>
                <input type="text" name="menu" placeholder="Type a folder name..." style="margin: 5px">
            <?php } else { ?>
                <input type="hidden" name="menu" value="<?= $category ?>">
            <?php } ?>
            <br><input type="file" name="uploadFile[]" multiple="multiple" style="margin: 5px">
            <br><input type="submit" value="submit" style="margin: 5px">
        </form>
        <?php if (isset($_SESSION['uploadErr'])) { ?>
            <span class="results noresult"><?= $_SESSION['uploadErr'] ?></span>
        <?php }
        unset($_SESSION['uploadErr']); ?>
    </div>
<?php include "teacherFooter.php"; ?>