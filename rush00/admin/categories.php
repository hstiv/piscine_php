<?php

session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}

$result = mysqli_query($mysqli, "SELECT * FROM $categories");
$categories_array = mysqli_fetch_all($result, MYSQLI_ASSOC);

$content =
<<<HTML
<a href='/admin/category.php'>Add new category</a>
<table class='admin__table'>
    <tr>
        <th>#</th>
        <th>Category</th>
        <th>Controls</th>
    </tr>
HTML;
foreach ($categories_array as $i => $category) {
    $content .= "<tr>";
    $content .= "<td>" .$category["category_id"]. "</td>";
    $content .= "<td>" .$category["category_name"]. "</td>";
    $content .= "<td>";
    $content .= "<a class='admin__edit' href='/admin/category.php?id=" .$category["category_id"]. "'>Edit</a>";
    $content .= "</td>";
    $content .= "</tr>";
}
$content .= "</table>";

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";