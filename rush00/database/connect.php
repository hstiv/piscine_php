<?php
/* This file manages connection to MySQL database */
/* MySQL server must be up and running: 'mysql.server start' */
/* Standard login:password is 'root:' */

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/config.php";

if ( !($mysqli = mysqli_connect( $db_host, $db_user, $db_passwd ) ) )
    exit("Error connectiong to database.");
if ( !mysqli_select_db($mysqli, $database) )
    exit("Error selecting database.");

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/functions.php";
