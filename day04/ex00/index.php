<?php
	session_start();
	$login = "";
	$pswd = "";
	if ($_GET["submit"] && $_GET["submit"] == "OK")
	{
		if ($_GET["login"])
			$_SESSION["login"] = $_GET["login"];
		if ($_GET["passwd"])
			$_SESSION["passwd"] = $_GET["passwd"];
	}
	if ($_SESSION["login"])
		$login = $_SESSION["login"];
	if ($_SESSION["passwd"])
		$pswd = $_SESSION["passwd"];
?>

<html><body>
	<form action="" method="GET">
		Username: <input type="text" name="login" value="<?echo"$login"?>" />
		<br />
		Password: <input type="text" name="passwd" value="<?echo "$pswd"?>" />
		<input type="submit" name="submit" value="OK" />
	</form>
</body></html>