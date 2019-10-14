<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}

$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";

$result = mysqli_query($mysqli, "SELECT user_login FROM $users_table WHERE user_id = $id");
$username = mysqli_fetch_assoc($result)["user_login"];

if ($_SESSION["logged_in_user"] == $username) {
    header("Location: /admin/users.php?e=1");
    exit;
}

mysqli_query( $mysqli, "DELETE FROM $users_table WHERE user_id = $id");
header("Location: /admin/users.php");