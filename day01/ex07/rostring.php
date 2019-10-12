#!/usr/bin/php
<?php
    $s = $argv[1];
    $s = trim($s);
    $arr = explode(" ", $s);
    for ($i = 0; $i < count($arr); )
    {
        $arr[$i] = trim($arr[$i]);
        if ($arr[$i] == NULL)
            array_splice($arr, $i, 1);
        else
            $i++;
    }
    $i = count($arr);
    for ($l = 1; $l < $i; $l++)
        echo "$arr[$l] ";
    echo "$arr[0]\n";
?>