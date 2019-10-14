<?php

session_start();

$content = "";

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}

$content = "<a class='admin__link' href='/admin/product.php'>Add new product</a>";

$result = mysqli_query($mysqli,
    "SELECT
    product_id AS id, category_name AS category, product_name AS title, product_description AS 'description', product_price AS price, product_photo AS photo
    FROM $products INNER JOIN $categories ON $categories.category_id = $products.category_id ORDER BY id");
$products_array = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($products_array) {
    $content .=
<<<HTML
<table class='admin__table'>
    <tr>
HTML;

    $columns = array_keys($products_array[0]);
    foreach ($columns as $column)
        $content .= "<th>" .ucfirst($column). "</th>";

    $content .=
<<<HTML
        <th>Controls</th>
    </tr>
HTML;

    foreach ($products_array as $product) {
        $content .= "<tr>";
        foreach ($product as $value) {
            $content .= "<td>$value</td>";
        }
        $content .= "<td>";
        $content .= "<a class='admin_edit' href='/admin/product.php?id=" .$product["id"]. "'>Edit</a>";
        $content .= " " . "<a class='admin__delete' href='/admin/methods/deleteProduct.php?id=" .$product["id"]. "'>Delete</a>";
        $content .= "</td>";
        $content .= "</tr>";
    }

    $content .= 
<<<HTML
    </table>
HTML;
} else
    $content .= "<div class='admin__status'>No products.</div>";


include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";