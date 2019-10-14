<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_logged() ) {
    header("Location: /admin/index.php");
    exit;
}

$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
mysqli_query( $mysqli, "DELETE FROM $news WHERE news_id = $id");

header("Location: /admin/news.php");