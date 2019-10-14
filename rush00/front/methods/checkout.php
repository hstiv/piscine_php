<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"]."/database/connect.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/front/functions.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/admin/functions.php";


// var_dump($_SESSION);
// var_dump($_POST);
/*
    order_id INT AUTO_INCREMENT PRIMARY KEY, // NULL
    order_contents TEXT NOT NULL,
        serialize order
    order_total INT NOT NULL,
    order_name VARCHAR(255) NOT NULL,
    order_phone VARCHAR(255) NOT NULL,
    order_address VARCHAR(255) NOT NULL"
*/
/* Get names and quantities */
$products_array = get_products_from_session();

foreach ($products_array as $product)
    $order_contents[] = array("id" => $product["id"], "title" => $product["title"], "quantity" => $product["quantity"]);

$order_contents = $order_contents ? array_to_order($order_contents) : "";
$order_contents = str_replace("'", "\'", $order_contents);

$order_total = isset( $_SESSION["total"] ) ? $_SESSION["total"] : 0;

$order_name = isset( $_POST["name"] ) ? filter_var($_POST["name"], FILTER_SANITIZE_STRING) : "";

$order_phone = isset( $_POST["phone"] ) ? filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT) : "";

$order_address = isset( $_POST["address"] ) ? filter_var($_POST["address"], FILTER_SANITIZE_STRING) : "";

if (!$order_name || !$order_phone || !$order_address) {
    header("Location: /cart.php?name=" .$_POST["name"]. "&phone=" .$_POST["phone"]. "&address=" .$order_address. "&e=1");
    exit;
}

if ($order_contents && $order_total && $order_name && $order_phone && $order_address) {
    $sql = "INSERT INTO $orders VALUES (NULL, '$order_contents', '$order_total', '$order_name', '$order_phone', '$order_address')";
    $result = mysqli_query($mysqli, $sql);
    $result = $result ? "1" : "0";
    header("Location: /order.php?result=$result");
    exit;
}
header("Location: /order.php?result=0");