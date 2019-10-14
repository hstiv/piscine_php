<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_logged() ) {
    header("Location: /admin/index.php");
    exit;
}

$id = isset( $_POST["id"] ) ? 
    filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT) : "";

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

if ($id && $order && $sum && $client && $phone && $address) {
    /* If no such order, can't edit */
    $result = mysqli_query($mysqli, "SELECT * FROM $orders WHERE order_id = '$id'");
    if ( !mysqli_num_rows($result) ) {
        header("Location: /admin/order.php?id=$id&result=0");
        exit;
    }
    $result = mysqli_query( $mysqli, "UPDATE $orders SET order_contents = '$order', order_total = '$sum', order_name = '$client', order_phone = '$phone', order_address = '$address' WHERE order_id = $id" );
    $result = $result ? "1" : "0";
    header("Location: /admin/order.php?id=$id&result=$result");
    exit;
}
header("Location: /admin/order.php?result=0");