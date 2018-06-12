#!/usr/bin/php
<?php

function ft_split($str) {
	$tab = array_filter(explode(' ', str_replace(array("\n", "\r", "\t"), " ", $str)), strlen);
	return ($tab);
}

function ft_category( $char ) {
	if ($char >= 'a' AND $char <= 'z')
		return (1);
	elseif ($char >= '0' AND $char <= '9')
		return (2);
	return (ord($char) ? 3 : 0);
}

function ft_sort( $a, $b ) {
	$low_a = strtolower($a);
	$low_b = strtolower($b);
	$i = 0;
	while ($low_a[$i] == $low_b[$i] AND ord($low_a[$i]))
		$i++;
	$A = ft_category($low_a[$i]);
	$B = ft_category($low_b[$i]);
	return ($A == $B ? strcmp($low_a, $low_b) : $A - $B);
}

$tab = array();
foreach ($argv as $key => $arg)
	if ($key)
		$tab = array_merge($tab, ft_split($arg));
usort($tab, ft_sort);
foreach ($tab as $elem)
	print($elem."\n");

?>
