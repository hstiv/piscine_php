#!/usr/bin/php
<?php
    function ft_split($str)
    {
        $str = trim($str);
        $a = array_filter(explode(":", $str), "strlen");
        return ($a);
    }

    function search_it($a, $b)
    {
        $b = ft_split($b);
        if (count($b) != 2)
            return (NULL);
        if (!strcmp($a, $b[0]))
            return ($b[1]);
    }

    $arr = array();
    if ($argc < 3)
        return (0);
    for ($i = 1; $i < $argc; $i++)
        array_push($arr, $argv[$i]);
    $res = NULL;
    for ($i = 1; $i < count($arr); $i++)
        $res = search_it($arr[0], $arr[$i]);
    if (count($res) != NULL)
        echo "$res\n";
?>