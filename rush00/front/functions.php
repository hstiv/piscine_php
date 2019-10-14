<?php

function is_in_cart($id) {
    $cart = $_SESSION["cart"];

    if (!$cart)
        return (false);
    foreach ($cart as $product)
        foreach ($product as $product_id => $quantity)
            if ($id == $product_id)
                return (true);
    return (false);
}

function delete_from_cart($id) {
    $cart = $_SESSION["cart"];

    if (!$cart)
        return (false);
    foreach ($cart as &$product)
        foreach ($product as $product_id => $quantity) {
            if ($id == $product_id)
                $product = [];
        }
    $_SESSION["cart"] = array_filter($cart);
}

function increase_quantity($id) {
    $cart = $_SESSION["cart"];

    if (!$cart)
        return ;
    foreach ($cart as &$product)
        foreach ($product as $product_id => &$quantity) {
            if ($id == $product_id) {
                $quantity++;
                $_SESSION["cart"] = $cart;
                return ;
            }
        }
}

function decrease_quantity($id) {
    $cart = $_SESSION["cart"];

    if (!$cart)
        return ;
    foreach ($cart as &$product)
        foreach ($product as $product_id => &$quantity) {
            if ($id == $product_id) {
                $quantity--;
                if ($quantity <= 0)
                    delete_from_cart($id);
                else
                    $_SESSION["cart"] = $cart;
                return ;
            }
        }
}

function get_products_from_session() {
    global $mysqli, $products;
    $cart = $_SESSION["cart"];

    if (!$cart)
        return ;
    /* Get product ids */
    foreach ($cart as $product)
        foreach ($product as $id => $quantity) {
            $result = mysqli_query($mysqli, "SELECT product_id AS id, product_name AS title, product_price AS price, product_photo AS photo FROM $products WHERE product_id = '$id'");
            $products_array[] = array_merge( mysqli_fetch_assoc($result), array("quantity" => $quantity));
        }
    return ($products_array);
}