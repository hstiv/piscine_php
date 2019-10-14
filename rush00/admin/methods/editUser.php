<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}

$id = isset( $_POST["id"] ) ? 
    filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT) : "";

$login = isset( $_POST["login"] ) ? 
    filter_var($_POST["login"], FILTER_SANITIZE_STRING) : "";

$newpw  = isset( $_POST["newpw"] ) ? 
    hash( "whirlpool", filter_var($_POST["newpw"], FILTER_SANITIZE_STRING) ) : "";

$name = isset( $_POST["name"] ) ? 
    filter_var($_POST["name"], FILTER_SANITIZE_STRING) : "";

$phone = isset( $_POST["phone"] ) ? 
    filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT) : "";

$address = isset( $_POST["address"] ) ? 
    filter_var($_POST["address"], FILTER_SANITIZE_STRING) : "";

if ($id && $login && $newpw) {
    /* If no such user, can't edit */
    $result = mysqli_query($mysqli, "SELECT * FROM $users_table WHERE user_id = '$id'");
    if ( !mysqli_num_rows($result) ) {
        header("Location: /admin/user.php?id=$id&result=2");
        exit;
    }

    $sql = "UPDATE $users_table SET user_password = '$newpw', user_login = '$login'";
    $sql .= $name ? ", user_name = '$name'" : "";
    $sql .= $phone ? ", user_phone = '$phone'" : "";
    $sql .= $address ? ", user_address = '$address'" : "";
    $sql .= " WHERE user_id = '$id'";
    $result = mysqli_query($mysqli, $sql);
    $result = $result ? "1" : "0";
    header("Location: /admin/user.php?id=$id&result=$result");
    exit;
}
header("Location: /admin/user.php?result=3");