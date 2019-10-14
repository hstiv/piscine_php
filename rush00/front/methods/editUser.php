<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /profile.php");
    exit;
}

$login = isset( $_POST["login"] ) ? 
    filter_var($_POST["login"], FILTER_SANITIZE_STRING) : "";

$passwd  = isset( $_POST["passwd"] ) ? 
    hash( "whirlpool", filter_var($_POST["passwd"], FILTER_SANITIZE_STRING) ) : "";

$name = isset( $_POST["name"] ) ? 
    filter_var($_POST["name"], FILTER_SANITIZE_STRING) : "";

$phone = isset( $_POST["phone"] ) ? 
    filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT) : "";

$address = isset( $_POST["address"] ) ? 
    filter_var($_POST["address"], FILTER_SANITIZE_STRING) : "";

if ($login && $passwd) {
    /* If no such user, can't edit */
    $result = mysqli_query($mysqli, "SELECT * FROM $users_table WHERE user_login = '$login'");
    if ( !mysqli_num_rows($result) ) {
        header("Location: /profile.php?id=$id&result=2");
        exit;
    }

    $sql = "UPDATE $users_table SET user_password = '$passwd'";
    $sql .= $name ? ", user_name = '$name'" : "";
    $sql .= $phone ? ", user_phone = '$phone'" : "";
    $sql .= $address ? ", user_address = '$address'" : "";
    $sql .= " WHERE user_login = '$login'";
    $result = mysqli_query($mysqli, $sql);
    $result = $result ? "1" : "0";
    header("Location: /profile.php?id=$id&result=$result");
    exit;
}
header("Location: /profile.php?result=2");