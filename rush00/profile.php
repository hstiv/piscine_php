<?php
session_start();

include_once $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

$content = "<div class='container'>";

/* Error reproting */
if ( isset( $_GET["e"] ) && $_GET["e"] == 1 )
    $content .= "<div class='page__error'>Incorrect login/password.</div>";

if ( is_logged() ) {
    $user = $_SESSION["logged_in_user"];

    $result = mysqli_query( $mysqli, "SELECT * FROM $users_table WHERE user_login = '$user'");
    $user_data = mysqli_fetch_assoc($result);

    $login = $user_data["user_login"] ? $user_data["user_login"] : "";
    $name = $user_data["user_name"] ? $user_data["user_name"] : "";
    $phone = $user_data["user_phone"] ? $user_data["user_phone"] : "";
    $address = $user_data["user_address"] ? $user_data["user_address"] : "";

    switch($_GET["result"]) {
        case "0":
            $error = "<div class='page__error'>Couldn't update database. Try again later.</div>";
            break;
        case "1":
            $error = "<div class='page__success'>Successfully updated profile.</div>";
            break;
        case "2":
            $error = "<div class='page__error'>There is no such user.</div>";
            break;
    }

    $content .= 
<<<HTML
    <div>Welcome, $user!</div>
    $error
    <form action='/front/methods/editUser.php' method='POST'>
        <div class='form__group'>
            <label class='form__label'>Login*:</label>
            <input class="page__input page__input_disabled" type="text" name="login" value="$login" readonly>
        </div>
        <div class='form__group'>
            <label class='form__label'>New Password*:</label>
            <input class="page__input" type="password" name="passwd" required>
        </div>
        <div class='form__group'>
            <label class='form__label'>Name:</label>
            <input class="page__input" type="text" name="name" value="$name">
        </div>
        <div class='form__group'>
            <label class='form__label'>Phone:</label>
            <input class="page__input" type="text" name="phone" value="$phone">
        </div>
        <div class='form__group'>
            <label class='form__label'>Address:</label>
            <input class="page__input" type="text" name="address" value="$address">
        </div>
        <input class="page__submit" type="submit" name="submit" value="OK">
    </form>
HTML;
} else {
    $content .= 
<<<HTML
    <div class="admin__header">Please, authenticate.</div>
    <form action='/front/methods/login.php' method='POST'>
        <div class='form__group'>
            <label class='form__label'>Name:</label>
            <input class="page__input" type="text" name="login" required>
        </div>
        <div class='form__group'>
            <label class='form__label'>Password:</label>
            <input class="page__input" type="password" name="passwd" required>
        </div>
        <input class="page__submit" type="submit" name="submit" value="OK">
    </form>
HTML;
}

$content .= "</div>";

include $_SERVER["DOCUMENT_ROOT"] . "/front/templates/page.php";