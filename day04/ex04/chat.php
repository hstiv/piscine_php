<?php
if (file_exists('../private/chat'))
{
	$content .=
	'<html>
		<head>
			<style>
				.time {
					color: grey;
					font-size: 0.7rem;
					margin-top: 5px;
					margin-left: 95%;
				}
				.name {
					color: blue;
					font-size: 0.9rem;
				}
				p {
					margin-bottom: 10px;
				}
			</style>
		</head>
		<body>';
	$chat = unserialize(file_get_contents('../private/chat'));
	foreach ($chat as $pole)
	{
		$content .= '<span class="name">'. $pole['login']. ' </span>';
		$content .= '<span class="time">'. date('H:i', $pole['time']). '</span>';
		$content .= '<br/><p>'. $pole['msg']. '</p><hr/>';
	}
	$content .=
		'</body>
	</html>';
	echo $content;
}