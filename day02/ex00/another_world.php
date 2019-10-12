#!/usr/bin/php
<?php
	if ($argc >= 2)
	{
		$arr = preg_split("/[\s,]+/", trim($argv[1]));
		for ($i = 0; $i < count($arr); $i++)
		{
			echo "$arr[$i]";
			if ($i + 1 != count($arr))
				echo " ";
		}
		echo "\n";
	}
?>