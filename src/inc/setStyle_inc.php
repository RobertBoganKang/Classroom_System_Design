<?php
if (!isset($_COOKIE['style']) || $_COOKIE['style'] == 0) {
} elseif ($_COOKIE['style'] == 1) { ?>
    <!--style1: Fun-->
    <link rel="stylesheet" href="../css/style1.css">
<?php } elseif ($_COOKIE['style'] == 2) { ?>
    <!--style2: Nude-->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style2.css">
<?php } ?>
