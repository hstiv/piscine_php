#!/usr/bin/php
<?php
	$a = 0;
	$b = 0;
	while ($a < 1000)
	{
		echo 'X';
		$a++;
		$b++;
		if ($b == 99)
		{
			echo "\n";
			$b = 0;
		}
	}
?>