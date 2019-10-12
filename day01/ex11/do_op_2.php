#!/usr/bin/php
<?php
	function c_ins($a, $c)
	{
		$i = 0;
		while($i < strlen($a) && $a[$i] != $c)
			$i++;
		return ($a[$i] == $c);
	}

	function symb_type($s)
	{
		$a = 0;
		$b = 0;
		if (c_ins($s, '+'))
		{
			$a = 1;
			$b++;
		}
		if (c_ins($s, '-'))
		{
			$a = 2;
			$b++;
		}
		if (c_ins($s, '*'))
		{
			$a = 3;
			$b++;
		}
		if (c_ins($s, '/'))
		{
			$a = 4;
			$b++;
		}
		if (c_ins($s, '%'))
		{
			$a = 5;
			$b++;
		}
		if ($b == 1 && $a != 0)
			return ($a);
		else
			return (0);
	}

	function sym_allign($s, $c)
	{
		if ($c == 1)
			return (array_filter(explode("+", $s), "strlen"));
		if ($c == 2)
			return (array_filter(explode("-", $s), "strlen"));
		if ($c == 3)
			return (array_filter(explode("*", $s), "strlen"));
		if ($c == 4)
			return (array_filter(explode("/", $s), "strlen"));
		if ($c == 5)
			return (array_filter(explode("%", $s), "strlen"));
	}

	function calc($s, $c)
	{
		$s[0] = intval($s[0]);
		$s[1] = intval($s[1]);
		$res = 0;
		if ($c == 1)
			$res = $s[0] + $s[1];
		else if ($c == 2)
			$res = $s[0] - $s[1];
		else if ($c == 3)
			$res = $s[0] * $s[1];
		else if ($c == 4)
			$res = $s[0] / $s[1];
		else if ($c == 5)
			$res = $s[0] % $s[1];
		echo "$res\n";

	}

	if ($argc < 2 || ($c = symb_type($argv[1])) == 0)
	{
		echo "Syntax Error\n";
		return (0);
	}
	$s = sym_allign(trim($argv[1]), $c);
	$s[0] = trim($s[0]);
	$s[1] = trim($s[1]);
	if (count($s) != 2 || !is_numeric($s[0]) || !is_numeric($s[1]) || ($c == 4 || $c == 5) && $s[1] == 0)
	{
		echo "Syntax Error\n";
		return (0);
	}
	calc($s, $c);
?>