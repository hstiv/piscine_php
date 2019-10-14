<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/front/functions.php";

$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
$action = isset( $_GET["action"] ) ? filter_var($_GET["action"], FILTER_SANITIZE_URL) : "";

if ($id && $action) {
    switch ($action) {
        case "increase":
            increase_quantity($id);
            break;
        case "decrease":
            decrease_quantity($id);
            break;
        default:
            break;
    }
}
header("Location: /cart.php");