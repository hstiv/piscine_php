<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}

/* If id - edit, else create new product */
$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
if ($id) {
    $result = mysqli_query($mysqli,
    "SELECT
    category_name AS category, product_name AS title, product_description AS 'description', product_price AS price, product_photo AS photo
    FROM $products INNER JOIN $categories ON $categories.category_id = $products.category_id WHERE product_id = $id");
    $product = mysqli_fetch_assoc($result);
}

$result = mysqli_query($mysqli,
    "SELECT
    category_name AS category, product_name AS title, product_description AS 'description', product_price AS price, product_photo AS photo
    FROM $products INNER JOIN $categories ON $categories.category_id = $products.category_id LIMIT 1"
);
$columns = array_keys( mysqli_fetch_assoc($result) );

switch ($_GET["result"]) {
    case "0":
        $error = "<div class='admin__error'>Couldn't update database.</div>";
        break;
    case "1":
        $error = "<div class='admin__success'>Successfully update database.</div>";
        break;
    case "2":
        $error = "<div class='admin__success'>Couldn't create new category: category_name is already taken.</div>";
        break;
    default:
        break;
}

$header = "<h2>" .($product["title"] ? "Edit '" .$product["title"] ."'" : "Create new product"). "</h2>";
$action = $id ? "/admin/methods/editProduct.php?id=$id" : "/admin/methods/newProduct.php";
$content .= 
<<<HTML
    $header
    $error
    <form class="admin__form" action=$action method="POST">
        <input type="hidden" name="id" value="$id">
HTML;

$result = mysqli_query($mysqli, "SELECT * FROM $categories");
$categories_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
$select = "<select name='category'>";
foreach ($categories_array as $category) {
    $selected = ($category["category_name"] == $product["category"] ? " selected" : "");
    $select .= "<option value='" .$category["category_id"]. "'" .$selected. ">" .$category["category_name"]. "</option>";
}
$select .= "</select>";

foreach ($columns as $column) {
    $content .= ucfirst($column). ": ";
    if ($column == "category") 
        $content .= $select;
    else
        $content .= "<input class='admin__input' type='text' name='$column' value='$product[$column]' required>";
    $content .= "<br>";
}

$content .=
<<<HTML
        <br>
        <input class="admin__button admin__button_submit" type="submit" name="submit" value="OK">
    </form>
HTML;

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";