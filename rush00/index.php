<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$content = 
<<<HTML
<div class='container'>
    <h2 class='index__header'>Featured products</h2>
HTML;

$result = mysqli_query($mysqli, "SELECT * FROM $products ORDER BY RAND() LIMIT 6");
$featured = mysqli_fetch_all($result, MYSQLI_ASSOC);

$content .= "<div class='catalog__products'>";
$content .= "<div class='row'>";
foreach ($featured as $product) {
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

$result = mysqli_query($mysqli, "SELECT * FROM $news ORDER BY news_id DESC LIMIT 3");
$news_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
if ($news_array ) {
    $content .= "<h2 class='index__header'>News</h2>";
    foreach ($news_array as $news) {
        $content .= "<div class='index__news'>";
        $content .= "<h3 class='news__title'>" .$news["news_title"]. "</h3>";
        $content .= "<div class='news__contents'>" .$news["news_contents"]. "</div>";
        $content .= "</div>";
    }
}


$content .= "</div>";

include $_SERVER["DOCUMENT_ROOT"]."/front/templates/page.php";