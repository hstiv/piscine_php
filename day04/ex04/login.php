<?php
session_start();

include "auth.php";
$_SESSION['loggued_on_user'] = array();

$iframe .=
'<html>
	<body>
		<iframe name="chat" src="chat.php" width="100%" height="550px"></iframe>
		<iframe name="speak" src="speak.php" width="100%" height="50px"></iframe>
		<form action="logout.php" method="get"><input type="submit" name="logout" value="Sign out"></form>
	</body>
</html>';

$login = $_POST['login'];
$passwd = $_POST['passwd'];
if (function_auth($login, $passwd) == true) {
	$_SESSION['loggued_on_user'] = $login;
	echo $iframe;
}
else {
	header('Location: index.html');
	echo "ERROR\n";
}