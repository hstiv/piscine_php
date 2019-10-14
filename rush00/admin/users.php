<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( !is_root() ) {
    header("Location: /admin/index.php");
    exit;
}
$content = "<a class='admin__link' href='/admin/user.php'>Add new user</a>";

$users = get_users();

if ($users) {
    switch ($_GET["e"]) {
        case "1":
            $error = "<div class='admin__error'>Can't delete self.</div>";
            break;
        default:
            break;
    }
    $content .=
<<<HTML
    $error
    <table class="users__table">
        <tr>
HTML;

    $table_columns = array_keys($users[0]);
    array_shift($table_columns);
    foreach ($table_columns as $th)
        $content .= "<th>" .ucfirst($th). "</th>";
    $content .= "</tr>";
    foreach ($users as $user) {
        $content .= "<tr>";
        $content .= "<td>" .$user["login"]. "</td>";
        $content .= "<td>" .$user["group name"]. "</td>";
        $content .= "<td>" .$user["name"]. "</td>";
        $content .= "<td>" .$user["phone"]. "</td>";
        $content .= "<td>" .$user["address"]. "</td>";
        $content .= "<td>";
        $content .= "<a class='admin__edit' href='/admin/user.php?id=" .$user["user_id"]. "'>Edit</a>";
        $content .= " " . "<a class='admin__delete' href='/admin/methods/deleteUser.php?id=" .$user["user_id"]. "'>Delete</a>";
        $content .= "</td>";
    }
    $content .= "</table>";
} else
    $content .= "<div class='admin__status'>No users.</div>";

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";