<?php
/*add dimensions*/
$office = $strcls->trimText(mysqli_real_escape_string($db, $_POST["office"]));

/*check office*/
if (empty($office)) {
    $officeErr = "Office location is required";
}
if ($lnameErr != '') {
    array_push($errorArr, 'office');
}