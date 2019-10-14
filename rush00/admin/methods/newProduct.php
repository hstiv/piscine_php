<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_logged() ) {
    header("Location: /admin/index.php");
    exit;
}

$category = isset( $_POST["category"] ) ? 
    filter_var($_POST["category"], FILTER_SANITIZE_NUMBER_INT) : "";

$title = isset( $_POST["title"] ) ?
    filter_var($_POST["title"], FILTER_SANITIZE_STRING) : "";

$description = isset( $_POST["description"] ) ?
    filter_var($_POST["description"], FILTER_SANITIZE_STRING) : "";

$price = isset( $_POST["price"] ) ? 
    filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT) : "";

$photo = isset( $_POST["photo"] ) ?
    filter_var($_POST["photo"], FILTER_SANITIZE_STRING) : "";

if ($category && $title && $description && $price && $photo) {
    $result = mysqli_query( $mysqli, "INSERT INTO $products VALUES (NULL, '$category', '$title', '$description', '$price', '$photo')" );
    $result = $result ? "1" : "0";
    header("Location: /admin/product.php?result=$result");
    exit;
}
header("Location: /admin/product.php?result=0");