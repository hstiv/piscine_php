<?php
if (isset($_GET['id']))
{
	if (($csvfile = fopen('list.csv', 'w')) !== FALSE)
	{
		fputcsv($csvfile, [$_GET['id'], $_GET['todo']], ';');
		fclose($csvfile);
		echo $_GET['id'] . ';' . $_GET['todo'];
	}
}
?>