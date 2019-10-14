<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/database/connect.php";

if ( is_logged() ) {
    header("Location: /profile.php");
    exit;
}

$content = "<div class='container'>";

$content .= "<h2 class='page__header'>Sign Up</h2>";

switch ($_GET["result"]) {
    case "0":
        $error = "<div class='page__error'>Couldn't update database.</div>";
        break;
    case "1":
        $error = "<div class='page__success'>Successfully update database.</div>";
        break;
    case "2":
        $error = "<div class='page__success'>Couldn't create new user: username is already taken.</div>";
        break;
    case "3":
        $error = "<div class='page__success'>Passwords don't match.</div>";
        break;
    default:
        break;
}

$content .= 
<<<HTML
    <div class="form__header">Please, fill the form.</div>
    $error
    <form action='/front/methods/newUser.php' method='POST'>
        <div class='form__group'>
            <label class='form__label'>Login*:</label>
            <input class="page__input page__input_disabled" type="text" name="login" value="" required>
        </div>
        <div class='form__group'>
            <label class='form__label'>New Password*:</label>
            <input class="page__input" type="password" name="passwd0" required>
        </div>
        <div class='form__group'>
            <label class='form__label'>Confirm Password*:</label>
            <input class="page__input" type="password" name="passwd1" required>
        </div>
        <input class="page__submit" type="submit" name="submit" value="OK">
    </form>
HTML;

$container .= "</div>";

include $_SERVER["DOCUMENT_ROOT"]."/front/templates/page.php";