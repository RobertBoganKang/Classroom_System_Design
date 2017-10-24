<?php

class errorPageFunc
{
    public function sendErrMsg($msg)
    {
        $_SESSION['errMsg'] = $msg;
        header("Location: " . "../errorPage/errorPage.php");
        exit;
    }
}