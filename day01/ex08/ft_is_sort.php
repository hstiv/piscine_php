<?php
function ft_cmp($a, $b)
{
	$i = 0;
	while ($i < strlen($a) && $i < strlen($b) && $a[$i] == $b[$i])
		$i++;
	if ($a[$i] != $b[$i])
		return (1);
	return (0);
}

function ft_is_sort($a)
{
	$b = array();
	for ($i = 0; $i < count($a); $i++)
		$b[] = $a[$i];
	sort($b);
	for ($i = 0; $i < count($a); $i++)
	{
		if (ft_cmp($a[$i], $b[$i]) != 0)
			return (false);
	}
	return (true);
}
?>