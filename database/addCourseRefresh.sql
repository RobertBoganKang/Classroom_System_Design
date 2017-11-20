DROP TABLE IF EXISTS `addcourse`; 

CREATE TABLE addcourse AS 
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
             ON course.teacher_id = teacher.id)); 

ALTER TABLE `classroom`.`addcourse` 
  ADD COLUMN `id` INT NOT NULL auto_increment first, 
  ADD PRIMARY KEY (`id`); 
