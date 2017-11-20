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
            $strbuilder .= $this->weekText($strarr[$i] - '0');
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

    public function shortenTime($time)
    {
        $stringbuilder = "";
        $arr = explode(":", $time);
        if ((int)$arr[0] > 12) {
            $stringbuilder .= (string)((int)$arr[0] - 12);
        } else {
            $stringbuilder .= (string)((int)$arr[0]);
        }
        $stringbuilder .= ":";
        $stringbuilder .= $arr[1];
        if ((int)$arr[0] >= 12) {
            $stringbuilder .= "AM";
        } else {
            $stringbuilder .= "PM";
        }
        return $stringbuilder;
    }

    /*print star*/
    public function starStr($star)
    {
        $starbuilder = '';
        for ($i = 0; $i < $star; $i++) {
            $starbuilder .= '*';
            if ($i != $star - 1) {
                $starbuilder .= ' ';
            }
        }
        return $starbuilder;
    }

    /*advanced search*/
    private function advTypeHelper($char, $var)
    {
        switch ($char) {
            case "0":
                return "cname LIKE '%$var%'";
            case "1":
                return "cdetail LIKE '%$var%'";
            case "2":
                return "tfname LIKE '%$var%' OR tlname LIKE '%$var%'";
            default:
                return "";
        }
    }

    public function advType($str, $var)
    {
        if (strlen($str) < 1) {
            return " ";
        } else {
            $sqlBuilder = " AND (";
            $strarr = str_split($str);
            for ($i = 0; $i < count($strarr); $i++) {
                $sqlBuilder .= (string)$this->advTypeHelper($strarr[$i], $var);
                if ($i != count($strarr) - 1) {
                    $sqlBuilder .= " OR ";
                }
            }
            $sqlBuilder .= ")";
            return $sqlBuilder;
        }
    }

    public function advWeek($str)
    {
        if (strlen($str) < 1) {
            return " ";
        } else {
            $strarr = str_split($str);
            sort($strarr);
            $str2 = implode($strarr);
            return "AND week LIKE '%$str2%'";
        }
    }

    /*time filter*/
    public function advTimeFilter(&$advGreater, &$advLess)
    {
        $sqlBuilder = " ";
        /*no define of time filter*/
        if ($advLess == "" && $advGreater == "" || $advLess <= $advGreater) {
            return "";
        } else {
            if ($advLess != "" && $advLess != "23:59") {
                $sqlBuilder .= " AND ";
                $sqlBuilder .= ("cend<='$advLess" . ":00'");
            }
            if ($advGreater != "" && $advLess != "00:00") {
                $sqlBuilder .= " AND ";
                $sqlBuilder .= ("cstart>='$advGreater" . ":00'");
            }
            if ($advLess == "") $advLess = "23:59";
            if ($advGreater == "") $advLess = "00:00";
        }
        return $sqlBuilder;
    }

    public function advFilter($char)
    {
        switch ($char) {
            case "0":
                return "cname ASC";
            case "1":
                return "rating DESC";
            case "2":
                return "nrating DESC";
            default:
                return "";
        }
    }

    /*checkbox color initializer*/
    public function ckbxColor($id, $val)
    {
        return (strpos($_GET[$id], $val) !== false) ? "green" : "lightgray";
    }
}