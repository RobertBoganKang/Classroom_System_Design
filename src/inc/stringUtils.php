<?php

class stringUtils
{
    public function trimText($data)
    {
        $data = trim($data);
        /*$data = stripslashes($data);*/
        $data = htmlspecialchars($data);
        return $data;
    }
}