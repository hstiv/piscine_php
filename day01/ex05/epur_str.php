#!/usr/bin/php
<?php
    $str = $argv[1];
    $str = trim($str);
    $d = 0;
    for ($i = 0; $i < strlen($str); $i++)
    {
        if ($d == 0 && $str[$i] != " ")
        {
            while ($str[$i] != " " && $str[$i])
                echo $str[$i++];
            $d = 1;
        }
        if ($d == 1 && $str[$i] == " ")
        {
            echo $str[$i];
            $d = 0;
        }
    }
    if ($str != NULL)
        echo "\n";
?>