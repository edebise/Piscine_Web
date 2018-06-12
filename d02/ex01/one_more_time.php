#!/usr/bin/php
<?php

if ($argc > 1) {
	date_default_timezone_set('Europe/Paris');
	if (preg_match('/^((lun|mar|mercre|jeu|vendre|same)di|dimanche) /i', $argv[1])
		AND preg_match('/^[A-Z]?[a-z]+ /', $argv[1])
		// AND print("\x1b[32m\tGood Day\n")
		AND preg_match('/^\w+ (0?[1-9]|[12]\d|3[01]) /', $argv[1])
		// AND print("\x1b[32m\tGood Number\n")
		AND preg_match('/^\w+ \d+ ((janv|f[ée]vr)ier|ma(rs|i)|avril|jui(n|llet)|ao[ûu]t|(septem|octo|novem|d[ée]cem)bre) /ui', $argv[1])
		AND preg_match('/^\w+ \d+ [A-Z]?[a-zéû]+ /u', $argv[1])
		// AND print("\x1b[32m\tGood Month\n")
		AND preg_match('/^\w+ \d+ \w+ (010[1-9]|01[1-9]\d|0[2-9]\d\d|[1-9]\d\d\d) /u', $argv[1])
		// AND print("\x1b[32m\tGood Year\n")
		AND preg_match('/^\w+ \d+ \w+ \d+ ([01]\d|2[0-3]):/u', $argv[1])
		// AND print("\x1b[32m\tGood Hour\n")
		AND preg_match('/^\w+ \d+ \w+ \d+ \d\d:[0-5]\d:/u', $argv[1])
		// AND print("\x1b[32m\tGood Minute\n")
		AND preg_match('/^\w+ \d+ \w+ \d+ \d\d:\d\d:[0-5]\d$/u', $argv[1])
		// AND print("\x1b[32m\tGood Seconde\n")
		)
	{
		$tab = explode(' ', $argv[1]);
		$tab[4] = explode(':', $tab[4]);
		// print_r($tab);
		$day = intval($tab[1]);
		$month = array('/^ja/i' => 1, '/^f/i' => 2, '/^mar/i' => 3, '/^av/i' => 4, '/^mai/i' => 5, '/^juin/i' => 6, 
			'/^juil/i' => 7, '/^ao/i' => 8, '/^sep/i' => 9, '/^oct/i' => 10, '/^nov/i' => 11, '/^d/i' => 12);
		foreach ($month as $key => $value)
			if (preg_match($key, $tab[2])) {
				$month = $value;
				break;
			}
		$year = intval($tab[3]);
		$hour = intval($tab[4][0]);
		$minute = intval($tab[4][1]);
		$seconde = intval($tab[4][2]);
		if (checkdate($month, $day, $year))
			exit(mktime($hour, $minute, $seconde, $month, $day, $year)."\n");
	}
	exit("Wrong Format\n");
}

?>
