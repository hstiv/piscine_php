<?php
	if ($_GET["action"] == "set")
		if ($_GET["name"] && $_GET["value"])
			setcookie($_GET["name"], $_GET["value"], time() + 86400, "/");
	if ($_GET["action"] == "del")
		if ($_GET["name"])
			setcookie($_GET["name"], "", time() - 86500 * 30);
	if ($_GET["action"] == "get")
		if ($_GET["name"])
			echo $_COOKIE[$_GET["name"]] . "\n";
?>