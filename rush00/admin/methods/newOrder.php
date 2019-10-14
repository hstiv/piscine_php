<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_logged() ) {
    header("Location: /admin/index.php");
    exit;
}

$order = isset( $_POST["order"] ) ? 
    filter_var($_POST["order"], FILTER_SANITIZE_STRING) : "";

$sum = isset( $_POST["sum"] ) ?
    filter_var($_POST["sum"], FILTER_SANITIZE_NUMBER_INT) : "";

$client = isset( $_POST["client"] ) ?
    filter_var($_POST["client"], FILTER_SANITIZE_STRING) : "";

$phone = isset( $_POST["phone"] ) ? 
    filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT) : "";

$address = isset( $_POST["address"] ) ?
    filter_var($_POST["address"], FILTER_SANITIZE_STRING) : "";

if ($order && $sum && $client && $phone && $address) {
    $result = mysqli_query( $mysqli, "INSERT INTO $orders VALUES (NULL, '$order', '$sum', '$client', '$phone', '$address')" );
    $result = $result ? "1" : "0";
    header("Location: /admin/order.php?result=$result");
    exit;
}
header("Location: /admin/order.php?result=2");