<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$login = isset( $_POST["login"] ) ? filter_var($_POST["login"], FILTER_SANITIZE_STRING) : "";

$pw0 = isset( $_POST["passwd0"] ) ? filter_var($_POST["passwd0"], FILTER_SANITIZE_STRING) : "";

$pw1 = isset( $_POST["passwd1"] ) ? filter_var($_POST["passwd1"], FILTER_SANITIZE_STRING) : "";

if ($pw1 && $pw0 && $pw0 != $pw1) {
    header("Location: /admin/user.php?result=3");
    exit;
}

$passwd = hash("whirlpool", $pw0);

if ($login && $pw0 && $passwd) {
    /* Check if the login is already taken */
    $result = mysqli_query($mysqli, "SELECT * FROM $users_table WHERE user_login = '$login'");
    if ( mysqli_num_rows($result) ) {
        header("Location: /admin/user.php?result=2");
        exit;
    }

    if ( !(mysqli_query($mysqli, "INSERT INTO $users_table VALUES (NULL, $group_id, '$login', '$passwd')") ) )
        header("Location: /register.php?result=0");
    else
        header("Location: /register.php?result=1");
    exit;
}
header("Location: /register.php?result=0");