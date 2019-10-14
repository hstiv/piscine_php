<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$result = filter_var($_GET["result"], FILTER_SANITIZE_NUMBER_INT);
$content = "<div class='container'>";

switch ($result) {
    case "0":
        $content .= "<div class='page__error'>An error occured while processing your order. Please, contact support or try again later.</div>";
        break;
    case "1":
        $content .= "<div class='page__error'>Thank you! An operator will contact your soon and confirm the order.</div>";
        unset($_SESSION["cart"]);
        unset($_SESSION["total"]);
        break;
    default:
        header("Location: /index.php");
        exit;
        break;
}
$content .= "</div>";

include $_SERVER["DOCUMENT_ROOT"]."/front/templates/page.php";