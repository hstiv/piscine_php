<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"]."/database/connect.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/front/functions.php";

$cart = $_SESSION["cart"];

$content = "<div class='container'>";
$content .= "<div class='cart'>";

if ( !$cart )
    $content .= "<div class='cart__empty'>Your cart is empty.</div>";
else {
    $products_array = get_products_from_session();

    $content .= "<div class='cart__order'>";
    $content .= 
<<<HTML
    <table class='cart__table'>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Title</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Controls</th>
        </tr>
HTML;
    $total = 0;
    $i = 0;
    foreach ($products_array as $product) {
        $content .= "<tr class='cart__row'>";
        $content .= "<td class='cart__format'>" .(++$i). "</td>";
        $content .= "<td class='cart__format'><img class='cart__image' src='/front/includes/images/products/" .$product["photo"]. "'></td>";
        $content .= "<td>" .$product["title"]. "</td>";
        $content .= "<td class='cart__format'>" .$product["price"]. "</td>";
        $content .= "<td class='cart__format'>" .$product["quantity"]. "</td>";
        $content .= "<td class='cart__format'>";
        $content .= "<a class='cart__increase' href='/front/methods/updateCart.php?action=increase&id=" .$product["id"]. "'>+</a>";
        $content .= " " ."<a class='cart__decrease' href='/front/methods/updateCart.php?action=decrease&id=" .$product["id"]. "'>-</a>";
        $content .= " " ."<a class='cart__delete' href='/front/methods/deleteFromCart.php?id=" .$product["id"]. "'>Delete</a>";
        $content .= "</td>";
        $content .= "</tr>";
        $total += $product["price"] * $product["quantity"];
    }
    $_SESSION["total"] = $total;
    $content .= "<tr class='cart__total'><td colspan='6'>Total: <span class='cart__sum'>$total</span></td></tr>";
    $content .= "</table>";
    
    $content .= "</div>";
    $content .= "<a class='cart__clear' href='/front/methods/deleteFromCart.php'>Clear cart</a>";
    
    $name = $_GET["name"];
    $phone = $_GET["phone"];
    $address = $_GET["address"];
    
    $error = $_GET["e"] == "1" ? "<p class='page__error'>Please, check information you provided.</p>" : "";
    
    $user = $_SESSION["logged_in_user"];
    $result = mysqli_query( $mysqli, "SELECT user_name, user_phone, user_address FROM $users_table WHERE user_login = '$user'");
    $user_data = mysqli_fetch_assoc($result);

    $name = $user_data["user_name"];
    $phone = $user_data["user_phone"];
    $address = $user_data["user_address"];

    $content .=
    <<<HTML
    <p class="cart__header">Details:</p>
    $error
    <form action='/front/methods/checkout.php' method='POST'>
        <div class='form__group'>
            <label class='form__label'>Name:</label>
            <input class="page__input" type="text" name="name" value="$name" required>
        </div>
        <div class='form__group'>
            <label class='form__label'>Phone:</label>
            <input class="page__input" type="tel" name="phone" value="$phone" required>
        </div>
        <div class='form__group'>
            <label class='form__label'>Address:</label>
            <input class="page__input" type="text" name="address" value="$address" required>
        </div>
        <input class="page__submit" type="submit" name="submit" value="Order">
    </form>
HTML;
}
$content .= "</div>";
$content .= "</div>";

include $_SERVER["DOCUMENT_ROOT"]."/front/templates/page.php"; 