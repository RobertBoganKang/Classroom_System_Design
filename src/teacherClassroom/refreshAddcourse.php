<?php
/*security check*/
require "securityCheck.php";

/*refresh our system here*/
$refreshSQL0 = "DROP TABLE IF EXISTS `addcourse`;";
$refreshSQL1 = "CREATE TABLE addcourse AS 
  (SELECT course.id             AS course_id, 
          semcourse.id          AS semcourse_id, 
          semcourse.semester_id AS semester_id, 
          course.cname          AS cname, 
          course.detail         AS cdetail, 
          teacher.id            AS tid, 
          teacher.fname         AS tfname, 
          teacher.lname         AS tlname, 
          semcourse.room        AS room, 
          semcourse.week        AS week, 
          semcourse.cstart      AS cstart, 
          semcourse.cend        AS cend, 
          course.rating         AS rating, 
          course.nrating        AS nrating 
   FROM   ((semcourse 
            JOIN course 
              ON course.id = semcourse.course_id) 
           JOIN teacher 
             ON course.teacher_id = teacher.id));";
$refreshSQL2 = "ALTER TABLE `classroom`.`addcourse` 
  ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT FIRST, 
  ADD PRIMARY KEY (`id`);";
$refresh = mysqli_query($db, $refreshSQL0);
if (!$refresh) {
    throw new Exception($db->error);
}
$refresh = mysqli_query($db, $refreshSQL1);
if (!$refresh) {
    throw new Exception($db->error);
}
$refresh = mysqli_query($db, $refreshSQL2);
if (!$refresh) {
    throw new Exception($db->error);
}