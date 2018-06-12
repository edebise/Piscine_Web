#!/usr/bin/php
<?php

function ft_split($str) {
	$tab = array_filter(explode(' ', str_replace(array("\n", "\r", "\t"), " ", $str)), strlen);
	return ($tab);
}

if ($argc > 1) {
	$tab = ft_split($argv[1]);
	$tab[] = array_shift($tab);
	print(implode(' ', $tab)."\n");
}

?>
