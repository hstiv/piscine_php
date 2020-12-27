<?php

session_start();

if (!$_SESSION['loggued_on_user'])
	echo "ERROR\n";
else {
	if (isset($_POST['send']) && isset($_POST['msg']) && $_POST['msg'] != '')
	{
		$content = array('login' => $_SESSION['loggued_on_user'], 'time' => time(), 'msg' => $_POST['msg']);
		if (!file_exists('../private/chat'))
		{
			if (!file_exists('../private'))
				mkdir('../private');
			file_put_contents('../private/chat','');
		}
		$chat = unserialize(file_get_contents('../private/chat'));
		$f = fopen('../private/chat', 'w');
		flock($f, LOCK_EX);
		$chat[] = $content;
		file_put_contents('../private/chat', serialize($chat));
		fclose($f);
	}
}
echo
'<html>
	<head>
		<script langage="javascript">top.frames["chat"].location = "chat.php";</script>
	</head>
	<body>
		<form action="speak.php" method="post">
			<input type="text" name="msg" style="width:96%"/>
			<input type="submit" name="send" value="Send""/>
		</form>
	</body>
</html>';
