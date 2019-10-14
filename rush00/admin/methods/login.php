<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$login = isset( $_POST["login"] ) ? filter_var($_POST["login"], FILTER_SANITIZE_STRING) : "";
$password = isset( $_POST["passwd"] ) ? filter_var($_POST["passwd"], FILTER_SANITIZE_STRING) : "";

if ( $login && $password && auth_admin( $login, $password ) ) {
	$_SESSION["logged_in_user"] = $_POST["login"];
	$_SESSION["admin"] = true;
	header("Location: /admin/index.php");
} else
	header("Location: /admin/index.php?e=1");