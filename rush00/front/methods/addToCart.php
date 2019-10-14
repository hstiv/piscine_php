<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/front/functions.php";

$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
$source = isset( $_GET["source"] )
    ? "/" .filter_var($_GET["source"], FILTER_SANITIZE_URL). ".php?id=$id"
    : "/catalog.php";

if ( is_in_cart($id) )
    increase_quantity($id);
else
    $_SESSION["cart"][] = array($id => 1);
header("Location: $source");