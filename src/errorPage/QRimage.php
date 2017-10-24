<?php
include "QR_BarCode.php";
session_start();
$qr = new QR_BarCode();
$qr->text($_SESSION['errMsg']);
$qr->qrCode();
session_unset();
session_destroy();