<?php
session_start();

include "auth.php";
$_SESSION['loggued_on_user'] = array();

$login = $_GET['login'];
$passwd = $_GET['passwd'];
if (function_auth($login, $passwd) == true) {
	$_SESSION['loggued_on_user'] = $login;
	echo "OK\n";
}
else {
	echo "ERROR\n";
}