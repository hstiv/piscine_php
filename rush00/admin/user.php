<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}

/* If id - edit, else create new user */
$id = isset( $_GET["id"] ) ? filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT) : "";
if ($id) {
    $result = mysqli_query( $mysqli, "SELECT * FROM $users_table WHERE user_id = $id");
    $user_data = mysqli_fetch_assoc($result);
    $group_select = "";
} else {
    $result = mysqli_query( $mysqli, "SELECT * FROM $user_groups");
    $groups = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $group_select = "Group: <select name='group_id'>";
    foreach ($groups as $group)
        $group_select .= "<option value='" .$group["group_id"]. "'>" .$group["group_name"]. "</option>";

    $group_select .= "</select><br>";
}

$login = $user_data["user_login"] ? $user_data["user_login"] : "";
$name = $user_data["user_name"] ? $user_data["user_name"] : "";
$phone = $user_data["user_phone"] ? $user_data["user_phone"] : "";
$address = $user_data["user_address"] ? $user_data["user_address"] : "";

switch ($_GET["result"]) {
    case "0":
        $error = "<div class='admin__error'>Couldn't update database.</div>";
        break;
    case "1":
        $error = "<div class='admin__success'>Successfully update database.</div>";
        break;
    case "2":
        $error = "<div class='admin__success'>Couldn't create new user: username is already taken.</div>";
        break;
    case "3":
        $error = "<div class='admin__success'>Incorrect information provided.</div>";
        break;
    default:
        break;
}

$header = "<h2>" .($login ? "Edit '$login'" : "Create new user"). "</h2>";
$pass_title = $login ? "New Password" : "Password";
$action = $login ? "/admin/methods/editUser.php?id=$id" : "/admin/methods/newUser.php";

$content .= 
<<<HTML
    $header
    $error
    <form class="admin__form" action=$action method="POST">
        <input type="hidden" name="id" value="$id">
        Username: <input class="admin__input" type="text" name="login" value="$login" required>
        <br>
        $group_select
        $pass_title: <input class="admin__input" type="password" name="newpw" required>
        <br>
        Name: <input class="admin__input" type="text" name="name" value="$name">
        <br>
        Phone: <input class="admin__input" type="text" name="phone" value="$phone">
        <br>
        Address: <input class="admin__input" type="text" name="address" value="$address">
        <br>
        <input class="admin__button admin__button_submit" type="submit" name="submit" value="OK">
    </form>
HTML;

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";