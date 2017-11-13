<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error Page</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/overall.css">
    <link rel="stylesheet" href="../css/loginSystemStyle.css">
</head>
<body>
<div class="panel">
    <?php
    session_start();
    if (isset($_SESSION['errMsg'])) { ?>
        <div class="nav"><a href="help.php" target="_blank">Help</a></div>
        <div style="display: inline-block">
            <h1 style="font-size: 60px">Error :(</h1>
            <img src="QRimage.php" alt="Image cannot be shown properly">
            <p>Please click help on top-right corner to contact developers to fix
                problem with this QR code attached!</p>
        </div>
    <?php } else { ?>
        <div class="nav"><a href="help.php">Help</a></div>
        <div style="display: inline-block">
            <h1 style="font-size: 60px">Page Not Found!</h1>
        </div>
    <?php } ?>
</div>
</body>
</html>