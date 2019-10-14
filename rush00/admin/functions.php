<?php

function array_to_order($array) {
    $string = array();
    foreach ($array as $item)
        $string[] = $item["quantity"] ."x " . $item["title"];
   return ( implode($string, ", ") );
}