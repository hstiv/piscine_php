<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}

$login = isset( $_POST["login"] ) ? 
    filter_var($_POST["login"], FILTER_SANITIZE_STRING) : "";

$group_id = isset( $_POST["group_id"] ) ?
    filter_var($_POST["group_id"], FILTER_SANITIZE_NUMBER_INT) : "";

$passwd = isset( $_POST["newpw"] ) ? 
    hash( "whirlpool", filter_var($_POST["newpw"], FILTER_SANITIZE_STRING) ) : "";

if ($login && $group_id && $passwd) {
    /* Check if the login is already taken */
    $result = mysqli_query($mysqli, "SELECT * FROM $users_table WHERE user_login = '$login'");
    if ( mysqli_num_rows($result) ) {
        header("Location: /admin/user.php?result=2");
        exit;
    }

    if ( !mysqli_query($mysqli, "INSERT INTO $users_table VALUES (NULL, $group_id, '$login', '$passwd')") )
        header("Location: /admin/user.php?result=0");
    else
        header("Location: /admin/users.php");
    exit;
}
header("Location: /admin/users.php?result=0");