<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$content = "<div class='container'>"; 

$content .= "<div class='catalogs__row'>";
$content .= "<div class='catalog__categories'>";
/* Add categories */
$result = mysqli_query($mysqli, "SELECT * FROM $categories");
$category_array = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($category_array as $category)
    $content .= "<a class='catalog__category' href='catalog.php?category=" .$category["category_id"]. "' id='" .$category["category_id"]. "'>" .$category["category_name"]. "</a>";
$content .= "<a class='catalog__category' href='catalog.php'>All</a>";

/* Add products */
$filter = isset( $_GET["category"] ) ? $_GET["category"] : "";
$sql = $filter ? " WHERE category_id = $filter" : "";
$result = mysqli_query($mysqli, "SELECT * FROM $products" . $sql);
$products_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
$content .= "</div>";
$content .= "<div class='catalog__products'>";
$content .= "<div class='row'>";
foreach ($products_array as $product) {
    $content .= 
    '<div class="catalog__col">
        <div class="catalog__product">
            <div class="catalog__image" style="background-image:url(\'/front/includes/images/products/' .$product["product_photo"]. '\')"></div>
            <div class="catalog__description">
                <p class="catalog__title">' .$product["product_name"]. '</p>
                <div class="catalog__buttons">
                    <a class="catalog__add" href="/front/methods/addToCart.php?id=' .$product["product_id"]. '">+</button>
                    <a class="catalog__more" href="/product.php?id=' .$product["product_id"]. '">More</a>
                    <p class="catalog__price">' .$product["product_price"]. '</p>
                </div>
            </div>
        </div>
    </div>';
}

$content .= "</div>";
$content .= "</div>";
$content .= "</div>";
$content .= "</div>";

include $_SERVER["DOCUMENT_ROOT"]."/front/templates/page.php";