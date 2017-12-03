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

    private function fullWeekText($wk)
    {
        switch ($wk) {
            case 0:
                return "Sunday";
            case 1:
                return "Monday";
            case 2:
                return "Tuesday";
            case 3:
                return "Wednesday";
            case 4:
                return "Thursday";
            case 5:
                return "Friday";
            case 6:
                return "Saturday";
            default:
                return "";
        }
    }

    public function fullstr2week($str)
    {
        $strarr = str_split($str);
        $strbuilder = "";
        for ($i = 0; $i < count($strarr); $i++) {
            $strbuilder .= $this->fullWeekText($strarr[$i] - '0');
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
        $stringbuilder .= (string)(((int)$arr[0] + 11) % 12 + 1);
        $stringbuilder .= ":";
        $stringbuilder .= $arr[1];
        if ((int)$arr[0] >= 12) {
            $stringbuilder .= "PM";
        } else {
            $stringbuilder .= "AM";
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
            if ($advLess != "") {
                $sqlBuilder .= " AND ";
                $sqlBuilder .= ("cend<='$advLess" . ":00'");
            }
            if ($advGreater != "") {
                $sqlBuilder .= " AND ";
                $sqlBuilder .= ("cstart>='$advGreater" . ":00'");
            }
            if ($advLess == "") $advLess = "00:00";
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
        return (strpos($_GET[$id], $val) !== false) ? "1" : "0";
    }

    /*print stars and dots, do not forget to import css for star system*/
    public function starDots($rowRating, $nrowRating, $mxpop)
    {
        return '
            <span class="stars' . round($rowRating) . '1 ratingdetails">' . bcdiv($rowRating * 10, 10, 1) . '</span>
            <span class="ratingstars">
            <span class="stars' . round($rowRating) . '1">*</span>
            <span class="dots' . round(5 * bcdiv($nrowRating, $mxpop, 3)) . '1">_</span>
            <span class="stars' . round($rowRating) . '2">*</span>
            <span class="dots' . round(5 * bcdiv($nrowRating, $mxpop, 3)) . '2">_</span>
            <span class="stars' . round($rowRating) . '3">*</span>
            <span class="dots' . round(5 * bcdiv($nrowRating, $mxpop, 3)) . '3">_</span>
            <span class="stars' . round($rowRating) . '4">*</span>
            <span class="dots' . round(5 * bcdiv($nrowRating, $mxpop, 3)) . '4">_</span>
            <span class="stars' . round($rowRating) . '5">*</span>
            <span class="dots' . round(5 * bcdiv($nrowRating, $mxpop, 3)) . '5">_</span>
        </span>
        <span class="popularity dots' . round(5 * bcdiv($nrowRating, $mxpop, 3)) . '5">' . $nrowRating . '</span>
        ';
    }

    /*just print stars*/
    public function starRating($rowRating)
    {
        return '
            <span class="stars' . round($rowRating) . '1 ratingdetails">' . bcdiv($rowRating * 10, 10, 1) . '</span>
            <span class="ratingstar">
            <span class="stars' . round($rowRating) . '1">*</span>
            <span class="stars' . round($rowRating) . '2">*</span>
            <span class="stars' . round($rowRating) . '3">*</span>
            <span class="stars' . round($rowRating) . '4">*</span>
            <span class="stars' . round($rowRating) . '5">*</span>
        </span>
        ';
    }

    /*star rating with your mouse; don't forget to import starSystem.js*/
    public function starManualRating($remember)
    {
        return '
<div class="starsPanel" onmouseleave="star_leave()">
    <span id="star_rate0" onmouseenter="star_rate(1);star_word(1)" onclick="remember=1">*</span>
    <span id="star_rate1" onmouseenter="star_rate(2);star_word(2)" onclick="remember=2">*</span>
    <span id="star_rate2" onmouseenter="star_rate(3);star_word(3)" onclick="remember=3">*</span>
    <span id="star_rate3" onmouseenter="star_rate(4);star_word(4)" onclick="remember=4">*</span>
    <span id="star_rate4" onmouseenter="star_rate(5);star_word(5)" onclick="remember=5">*</span>
    <span class="star_word star_not_activate" id="star_word"></span>
</div>
<script>remember=' . $remember . ';star_word(remember);star_rate(remember);</script>';
    }

    /*grade conversion*/
    public function gradStr2Num($str)
    {
        switch ($str) {
            case "A+":
                return 4;
            case "A":
                return 4;
            case "A-":
                return 3.6666666667;
            case "B+":
                return 3.3333333333;
            case "B":
                return 3;
            case "B-":
                return 2.6666666666;
            case "C+":
                return 2.3333333333;
            case "C":
                return 2;
            case "C-":
                return 1.6666666666;
            case "F+":
                return 1.3333333333;
            case "F":
                return 1;
            case "W":
                return 0;
            default:
                return 0;
        }
    }
}