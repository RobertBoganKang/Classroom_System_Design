<?php
$uploads = $_FILES['uploadFile'];
$course_id = $_POST['course_id'];
$category = $_POST['menu'];

print_r($uploads);
for ($i = 0; $i < count($uploads['name']); $i++) {
    $fileName = $uploads['name'][$i];
    $fileSize = $uploads['size'][$i];
    /*get name and extension*/
    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
}
