#!/usr/bin/php
<?php
	function is_sym($a)
	{
		return ($a == "+" || $a == "-" || $a == "*" || $a == "/" || $a == "%");
	}

	if ($argc != 4)
	{
		echo "Incorrect Parameters\n";
		return (0);
	}
	$arr = array();
	for ($i = 1; $i < $argc; $i++)
		array_push($arr, trim($argv[$i]));
	$arr[0] = intval($arr[0]);
	$arr[2] = intval($arr[2]);
	if (!is_numeric($arr[0]) || !is_numeric($arr[2]) || !is_sym($arr[1]) || (($arr[2] == 0) && ($arr[1] == "/" || $arr[1] == "%")))
	{
		echo "Incorrect Parameters\n";
		return (0);
	}
	$a = 0;
	if ($arr[1] == "+")
		$a = $arr[0] + $arr[2];
	else if ($arr[1] == "-")
		$a = $arr[0] - $arr[2];
	else if ($arr[1] == "*")
		$a = $arr[0] * $arr[2];
	else if ($arr[1] == "/")
		$a = $arr[0] / $arr[2];
	else if ($arr[1] == "%")
		$a = $arr[0] % $arr[2];
	echo "$a\n";
?>