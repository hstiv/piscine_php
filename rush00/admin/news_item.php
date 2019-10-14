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
    $result = mysqli_query( $mysqli, "SELECT * FROM $news WHERE news_id = $id");
    $news_array = mysqli_fetch_assoc($result);
}
$news_title = $news_array["news_title"] ? $news_array["news_title"] : "";
$news_contents = $news_array["news_contents"] ? $news_array["news_contents"] : "";

switch ($_GET["result"]) {
    case "0":
        $error = "<div class='admin__error'>Couldn't update database.</div>";
        break;
    case "1":
        $error = "<div class='admin__success'>Successfully update database.</div>";
        break;
    default:
        break;
}

$header = "<h2>" .($id ? "Edit '$news_title'" : "Create news"). "</h2>";
$action = $category_name ? "/admin/methods/editNews.php?id=$id" : "/admin/methods/newNews.php";
$content .= 
<<<HTML
    $header
    $error
    <form class="admin__form" action=$action method="post">
        <input type="hidden" name="id" value="$id">
        News Title: <input class="admin__input" type="text" name="news_title" value="$news_title" required>
        <br>
        News Contents: <input class="admin__input" type="text" name="news_contents" value="$news_contents" required>
        <br>
        <input class="admin__button admin__button_submit" type="submit" name="submit" value="OK">
    </form>
HTML;

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";