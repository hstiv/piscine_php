<?php
    function ft_split($str)
    {
        $str = trim($str);
        $a = array_filter(explode(" ", $str), "strlen");
        sort($a);
        return ($a);
    }
?>