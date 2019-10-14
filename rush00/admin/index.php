<?php
session_start();

$content = "";

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

/* Error reproting */
if ( isset( $_GET["e"] ) && $_GET["e"] == 1 )
    $content .= "<div class='admin__error'>Incorrect login/password.</div>";

if ( is_admin() ) {
    $user = $_SESSION["logged_in_user"];
    $content .= "<div>Welcome, $user!</div>";
} else {
    $content .= 
<<<HTML
    <div class="admin__header">Please, authenticate.</div>
    <div>
        <form class="admin__form" action="/admin/methods/login.php" method="POST">
            Username: <input class="admin__input" type="text" name="login">
            <br>
            Password: <input class="admin__input" type="password" name="passwd">
            <br>
            <input class="admin__button admin__button_submit" type="submit" name="submit" value="OK">
        </form>
    </div>
HTML;
}

include $_SERVER["DOCUMENT_ROOT"] . "/admin/templates/admin.php";