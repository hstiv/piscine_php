<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/front/functions.php";

$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
$source = isset( $_GET["source"] ) ? filter_var($_GET["source"], FILTER_SANITIZE_URL) : "/cart.php";

if ( $id ) 
    delete_from_cart($id);
else
    $_SESSION["cart"] = [];
header("Location: $source");