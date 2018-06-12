<?php

function ft_split($str) {
	$str = str_replace(array("\n", "\r", "\t"), " ", $str);
	$tab = explode(' ', $str);
	$tab = array_filter($tab, strlen);
	sort($tab);
	return ($tab);
}

?>
