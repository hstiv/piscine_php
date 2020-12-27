<?php

session_start();

if (isset($_GET['submit']) && $_GET['submit'] == 'OK') {
	if (isset($_GET['login']))
		$_SESSION['login'] = $_GET['login'];
	if (isset($_GET['passwd']))
		$_SESSION['passwd'] = $_GET['passwd'];
}

echo 
'<html>
	<body>
		<form action="" method="GET">
			Username: <input type="text" name="login" value= "'. (isset($_SESSION["login"]) ? $_SESSION["login"] : ''). '" />
			<br/>
			Password: <input type="text" name="passwd" value= "'. (isset($_SESSION["passwd"]) ? $_SESSION["passwd"] : ''). '" />
			<input type="submit" name="submit" value="OK" />
		</form>
	</body>
</html>';