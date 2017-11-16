<?php

class courseUtil
{
    /*convert string to integer array*/
    public function str2intarr($str)
    {
        $strarr = str_split($str);
        $array = array();
        foreach ($strarr as &$value)
            array_push($array, $value);
        return $array;
    }

    /*convert number to week string*/
    private function weekText($wk)
    {
        switch ($wk) {
            case 0:
                return "Su";
            case 1:
                return "Mo";
            case 2:
                return "Tu";
            case 3:
                return "We";
            case 4:
                return "Th";
            case 5:
                return "Fr";
            case 6:
                return "Sa";
            default:
                return "";
        }
    }

    public function str2week($str)
    {
        $strarr = str_split($str);
        $strbuilder = "";
        for ($i = 0; $i < count($strarr); $i++) {
            $strbuilder = $strbuilder . $this->weekText($strarr[$i] - '0');
            if ($i != count($strarr) - 1) {
                $strbuilder = $strbuilder . ", ";
            }
        }
        return $strbuilder;
    }

    public function semester2str($sem)
    {
        switch ($sem) {
            case "0":
                return "Spring";
            case "1":
                return "Summer";
            case "2":
                return "Fall";
            default:
                return "";
        }
    }
}