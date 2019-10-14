<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$id = isset( $_GET["id"] ) ? $_GET["id"] : "";
if (!$id) {
    header("Location: /catalog.php");
    exit;
}

$result = mysqli_query($mysqli, "SELECT category_name AS category, product_name AS title, product_description AS 'description', product_price AS price, product_photo FROM $products INNER JOIN $categories ON $products.category_id = $categories.category_id WHERE product_id = $id");
$product_info = mysqli_fetch_assoc($result);

$content = 
<<<HTML
<div class='container'>
    <div class='product'>
HTML;
$content .= "<div class='product__photo'>";
$content .= "<img class='product__image' src='/front/includes/images/products/" .$product_info["product_photo"]. "'>";
$content .= "<div class='product__description'>";
array_pop($product_info);
foreach ($product_info as $key => $value)
    $content .= "<div><span class='product__title'>" .ucfirst($key). ":</span> <span class='product__value" .($key == "price" ? " product__value_price" : ""). "'>$value</span></div>";
$content .= "<div class='product__buttons'>";
$content .= "<a class='product__add' href='/front/methods/addToCart.php?id=$id&source=product'>Add to cart</a>";

$content .= "</div>";
$content .= "</div>";
$content .= "</div>";
$content .= "</div>";

include $_SERVER["DOCUMENT_ROOT"]."/front/templates/page.php";
