<?php include "teacherHeaderNoSetting.php";
$course_id = $_POST['course_id'];
if (isset($_POST['menu'])) {
    $category = $_POST['menu'];
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
            <?php if (!isset($_POST['menu'])) { ?>
                <input type="text" name="menu" placeholder="Type a folder name...">
            <?php } else { ?>
                <input type="hidden" name="menu" value="<?= $category ?>">
            <?php } ?>
            <br><input type="file" name="uploadFile[]" multiple="multiple">
            <br><input type="submit" value="submit">
        </form>
    </div>
<?php include "teacherFooter.php"; ?>