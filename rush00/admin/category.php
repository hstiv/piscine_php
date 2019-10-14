<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_admin() ) {
    header("Location: /admin/index.php");
    exit;
}

/* If id - edit, else create new user */
$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
if ($id) {
    $result = mysqli_query( $mysqli, "SELECT * FROM $categories WHERE category_id = $id");
    $category_data = mysqli_fetch_assoc($result);
}
$category_name = $category_data["category_name"] ? $category_data["category_name"] : "";

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

$header = "<h2>" .($category_name ? "Edit '$category_name'" : "Create new category"). "</h2>";
$action = $category_name ? "/admin/methods/editCategory.php?id=$id" : "/admin/methods/newCategory.php";
$content .= 
<<<HTML
    $header
    $error
    <form class="admin__form" action=$action method="post">
        <input type="hidden" name="id" value="$id">
        Category name: <input class="admin__input" type="text" name="category_name" value="$category_name" required>
        <br>
        <input class="admin__button admin__button_submit" type="submit" name="submit" value="OK">
    </form>
HTML;

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";