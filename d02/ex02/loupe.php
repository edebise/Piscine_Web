#!/usr/bin/php
<?php

function	ft_replace_1( $tab ) {
	// print("\t\x1b[33m".$tab[0]."\x1b[0m\n");
	// print_r($tab);
	return ($tab[1].strtoupper($tab[2]).$tab[3]);
	// return ($tab[1]."\x1b[36m".strtoupper($tab[2])."\x1b[0m".$tab[3]);
}

function	ft_replace_0( $tab ) {
	// print("\t\x1b[33m".$tab[0]."\x1b[0m\n");
	return (preg_replace_callback(array('/(>)([^><]+)(<)/U', '/(title=")([^"]+)(")/iU'), ft_replace_1, $tab[0]));
}

if ($argc > 1 AND $html = file_get_contents($argv[1], 'r')) {
	// print("\x1b[32m".$html."\x1b[0m");
	print(preg_replace_callback('/<a .*<\/a>/sU', ft_replace_0, $html));
}

?>
