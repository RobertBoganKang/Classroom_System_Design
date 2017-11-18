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
<hr>
<h2>Courses</h2>
<hr class="hr">
<a class="advance" href="selectSemester.php">Add Course</a>
<span class="results noresult">No Course Available</span>
<?php include "studentFooter.php"; ?>
