#!/usr/bin/php
<?php

function	ft_replace( $match ) {
	// print($match[0]);
	return (array_shift($GLOBALS['sort']));
}

if ($argc > 1 AND $file = @file_get_contents($argv[1])) {
	$pattern = '/\d\d:\d\d:\d\d,\d\d\d\s*-->\s*\d\d:\d\d:\d\d,\d\d\d\n\w*\n/';
	preg_match_all($pattern, $file, $match);
	$sort = $match[0];
	// print_r($match[0]);
	sort($sort);
	// print_r($sort);
	print(preg_replace_callback($pattern, ft_replace, $file));
}

?>
