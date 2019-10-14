<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$login = isset( $_POST["login"] ) ? filter_var($_POST["login"], FILTER_SANITIZE_STRING) : "";
$password = isset( $_POST["passwd"] ) ? filter_var($_POST["passwd"], FILTER_SANITIZE_STRING) : "";

if ( $login && $password && auth( $login, $password ) ) {
	$_SESSION["logged_in_user"] = $_POST["login"];
	header("Location: /profile.php");
} else
	header("Location: /profile.php?e=1");