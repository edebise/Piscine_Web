#!/usr/bin/php
<?php

function ft_split($str) {
	$tab = array_filter(explode(' ', str_replace(array("\n", "\r", "\t"), " ", $str)), strlen);
	sort($tab);
	return ($tab);
}

$tab = array();
foreach ($argv as $key => $arg) {
	if ($key)
		$tab = array_merge($tab, ft_split($arg));
}
sort($tab);
foreach ($tab as $elem) {
	print($elem."\n");
}

?>
