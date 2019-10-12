#!/usr/bin/php
<?php
    function ft_split($str)
    {
        $str = trim($str);
        $a = array_filter(explode(" ", $str), "strlen");
        sort($a);
        return ($a);
    }
	
	function is_alpha($a)
	{
		return ($a >= 'A' && $a <= 'Z');
	}

	function is_symb($a)
	{
		return (!is_numeric($a) && !is_alpha($a));
	}

    function cmp($a, $b)
    {
		if ($a != $b)
		{
			if ((is_alpha($a) && is_alpha($b)
				|| is_numeric($a) && is_numeric($b)
				|| is_symb($a) && is_symb($b)) && $a != $b)
				return (($a < $b) ? (1) : (-1));
			else if (is_alpha($a) && (is_numeric($b) || is_symb($b)))
				return (1);
			else if (is_alpha($b) && (is_numeric($a) || is_symb($a)))
				return (-1);
			else if (is_numeric($a) && is_symb($b))
				return (1);
			else if (is_numeric($b) && is_symb($a))
				return (-1);
		}
		return (0);
    }

    function cmp_alph($a, $b)
    {
		$i = 0;
		$a = strtoupper($a);
		$b = strtoupper($b);
        while ($i < strlen($a) && $i < strlen($b) && !cmp($a[$i], $b[$i]))
			$i++;
		return (cmp($a[$i], $b[$i]));
    }

	$arr = array();
	for ($i = 1; $i < $argc; $i++)
	{
		$tmp = ft_split($argv[$i]);
		for ($j = 0; $j < count($tmp); $j++)
			array_push($arr, $tmp[$j]);
	}
	usort($arr, "cmp_alph");
	for ($i = count($arr) - 1; $i >= 0; $i--)
		echo "$arr[$i]\n";
?>