#!/usr/bin/php
<?php
echo "Enter a number: ";
while (($line = fgets(STDIN)) != NULL)
{
	$line = rtrim($line);
	if (is_numeric($line) == false)
	{
		echo "'$line' is not a number\n";
	}
	else
	{
		$a = intval($line);
		if ($a % 2 == 0)
			echo "The number $a is even\n";
		else
			echo "The number $a is odd\n";
	}
	echo "Enter a number: ";
}
echo "\n";
?>