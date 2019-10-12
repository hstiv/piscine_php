#!/usr/bin/php
<?php
    function ft_split($str)
    {
        $str = trim($str);
        $a = array_filter(explode(" ", $str), "strlen");
        sort($a);
        return ($a);
    }

    $arr = array();
    for ($i = 1; $i < $argc; $i++)
    {
        $a = ft_split($argv[$i]);
        for ($j = 0; $a[$j] != NULL; $j++)
            array_push($arr, $a[$j]);
    }
    sort($arr);
    for ($i = 0; $arr[$i] != NULL; $i++)
        echo "$arr[$i]\n";
?>