<div class="nav">
    <a href="studentMain.php">Home</a>
    / <a href="#">Upload</a>
    / <a href="classroomDownload.php?course_id=<?= $_GET['course_id'] ?>">Download</a>
    / <a href="../loginSystem/logout.php">Logout</a>
</div>
<div class="navl" id="navl">
            <span style="color:dimgray;cursor: pointer"
                  onclick="setTimeout(function(){document.getElementById('classroomSidebar').style.display = 'block'},10)">[+]</span>
</div>