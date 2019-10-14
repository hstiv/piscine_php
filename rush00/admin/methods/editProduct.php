<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}

$id = isset( $_POST["id"] ) ? 
    filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT) : "";

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

if ($id && $category && $title && $description && $price && $photo) {
    /* If no such product, can't edit */
    $result = mysqli_query($mysqli, "SELECT * FROM $products WHERE product_id = '$id'");
    if ( !mysqli_num_rows($result) ) {
        header("Location: /admin/product.php?id=$id&result=0");
        exit;
    }
    $result = mysqli_query( $mysqli, "UPDATE $products SET category_id = '$category', product_name = '$title', product_description = '$description', product_price = '$price', product_photo = '$photo' WHERE product_id = $id" );
    $result = $result ? "1" : "0";
    header("Location: /admin/product.php?id=$id&result=$result");
    exit;
}
header("Location: /admin/product.php?result=0");