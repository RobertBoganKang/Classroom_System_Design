<?php include "studentHeader.php"; ?>
    <script src="../js/overall.js"></script>
    <script src="../js/starSystem.js"></script>
    <link rel="stylesheet" href="../css/couseSearch.css">
    <link rel="stylesheet" href="../css/starSystems.css">
    <div>
        <?php
        try {
            /*load php functions*/
            require_once "../inc/courseUtil.php";
            $coursecls = new courseUtil();
            /**write something here*/
            echo $coursecls->starManualRating(0);
        } catch (Exception $e) {
            require_once "../errorPage/errorPageFunc.php";
            $cls = new errorPageFunc();
            $cls->sendErrMsg($e->getMessage());
        }
        ?>
    </div>
<?php include "studentFooter.php"; ?>