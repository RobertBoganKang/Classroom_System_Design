<?php include "studentHeaderNoSetting.php"; ?>
<script src="../js/overall.js"></script>
<link rel="stylesheet" href="../css/couseMaster.css">
<div>
    <?php
    try {
    /*if not connect in the header file, connect database*/
    if (!isset($p)) {
        /*connect database*/
        include "../inc/connect_inc.php";
    }

    /*get teacher id*/
    $teacher_id = $_GET['tid'];
    $teacher = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM teacher WHERE id=$teacher_id"));
    if (!$teacher) {
        throw new Exception($db->error);
    }
    ?>
    <title><?= $teacher['fname'] . ' ' . $teacher['lname'] ?>'s Profile</title>
    <h1><?= $teacher['fname'] . ' ' . $teacher['lname'] ?></h1>
    <div class="container-fluid">
        <!--Email-->
        <div class="row">
            <div class="col-sm-3 title">
                <span class="title">Email:</span></div>
            <div class="col-sm-9 coursedetail">
                <span><?= $teacher['email'] ?></span>
            </div>
        </div>
        <hr>
        <!--phone-->
        <div class="row">
            <div class="col-sm-3 title">
                <span class="title">Phone:</span></div>
            <div class="col-sm-9 coursedetail">
                <span><?= $teacher['phone'] ?></span>
            </div>
        </div>
        <hr>
        <!--office-->
        <div class="row">
            <div class="col-sm-3 title">
                <span class="title">Office:</span></div>
            <div class="col-sm-9 coursedetail">
                <span><?= $teacher['office'] ?></span>
            </div>
        </div>
        <hr>
        <?php

        } catch (Exception $e) {
            require_once "../errorPage/errorPageFunc.php";
            $cls = new errorPageFunc();
            $cls->sendErrMsg($e->getMessage());
        }
        ?>
    </div>
    <?php include "studentFooter.php"; ?>
