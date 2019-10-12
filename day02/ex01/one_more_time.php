#!/usr/bin/php
<?php
	function err()
	{
		echo "Wrong Format\n";
		return (0);
	}

	if ($argc < 2)
		return (0);
	$months = array("janvier", "fevrier", "mars", "avril", "mai", "juin",
	"juillet", "aout", "septembre", "octobre", "novembre", "decembre");
	$week_days = array("lundi", "mardi", "mercredi", "jeudi", "vendredi",
	 "samedi", "dimanche");
	$wday_c = "(?<week_day>[Ll]undi|[Mm]ardi|[Mm]ercredi|[Jj]eudi|[Vv]endredi|[Ss]amedi|[Dd]imanche)";
	$day_c = "(?<day>[0-3][0-9])";
	$month_c = "(?<month>[Jj]anvier|[Ff]evrier|[Mm]ars|[Aa]pril|[Mm]ai|[Jj]uin|[Jj]uillet|[Aa]out|[Ss]eptembre|[Oo]ctobre|[Nn]ovembre|[Dd]ecembre)";
	$year_c = "(?<year>[1-2][0-9]{3})";
	$time_c = "(?<time>[0-2][0-9]:[0-6][0-9]:[0-6][0-9])";
	if (!preg_match("/$wday_c $day_c $month_c $year_c $time_c/", $argv[1], $matches))
		return (err());
	$eat .= $matches["year"];
	$eat .= ":";
	$eat .= array_search(strtolower($matches["month"]), $months) + 1;
	$eat .= ":";
	$eat .= $matches["day"];
	$eat .= " ";
	$eat .= $matches["time"];
	date_default_timezone_set("Europe/Moscow");
	if (!($eat = strtotime($eat)) || date("w", $eat) != (array_search(strtolower($matches["week_day"]), $week_days) + 1))
		return (err());
	echo "$eat\n";
?>