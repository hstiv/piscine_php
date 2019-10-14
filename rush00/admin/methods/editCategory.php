<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}

$id = isset( $_POST["id"] ) ? 
    filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT) : "";

$category_name = isset( $_POST["category_name"] ) ? 
    filter_var($_POST["category_name"], FILTER_SANITIZE_STRING) : "";

if ($id && $category_name) {
    $result = mysqli_query( $mysqli, "UPDATE $categories SET category_name = '$category_name' WHERE category_id = $id" );
    $result = $result ? "1" : "0";
    header("Location: /admin/category.php?id=$id&result=$result");
    exit;
}
header("Location: /admin/category.php?result=0");