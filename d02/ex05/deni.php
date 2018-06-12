#!/usr/bin/php
<?php

if ($argc > 2 AND $fd = @fopen($argv[1], 'r') AND $title = @fgetcsv($fd, 0, ';') AND in_array($argv[2], $title))
{
	foreach ($title as $tab)
		$$tab = array();
	while ($csv = fgetcsv($fd, 0, ';'))
		if (sizeof($csv) == sizeof($title)) {
			$csv = array_combine($title, $csv);
			$key = $csv[$argv[2]];
			foreach ($title as $tab)
				$$tab += [$key => $csv[$tab]];
		}
	fclose($fd);
	// foreach ($title as $tab)
	// 	print_r($$tab);
	// print_r($$argv[2]);
	while (print('Entrez votre commande: ') AND $gnl = fgets(STDIN))
		if (is_bool(@eval($gnl)))
			print("PHP Parse error:  syntax error, unexpected T_STRING in [....]\n");
	print("^D\n");
}

?>
