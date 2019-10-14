<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_logged() ) {
    header("Location: /admin/index.php");
    exit;
}

$news_title = isset( $_POST["news_title"] ) ? 
    filter_var($_POST["news_title"], FILTER_SANITIZE_STRING) : "";

$news_contents = isset( $_POST["news_contents"] ) ?
    filter_var($_POST["news_contents"], FILTER_SANITIZE_STRING) : "";

if ($news_title && $news_contents) {
    $result = mysqli_query( $mysqli, "INSERT INTO $news VALUES (NULL, '$news_title', '$news_contents')" );
    $result = $result ? "1" : "0";
    header("Location: /admin/news.php?result=$result");
    exit;
}
header("Location: /admin/news.php?result=0");