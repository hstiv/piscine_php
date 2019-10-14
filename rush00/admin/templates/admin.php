<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";
    
    include "header.php";

    if ( isset($content) )
        echo $content ;

    include "footer.php";