<?php
if (($csvfile = fopen('list.csv', 'r')) !== FALSE)
{
	$i = 0;
	while (($csvdata = fgetcsv($csvfile)) !== FALSE)
	{
		$data .= $i > 0 ? '|' : '';
		$data .= $csvdata[0];
		$i++;
	}
	fclose($csvfile);
	echo $data;
}
?>