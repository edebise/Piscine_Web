#!/usr/bin/php
<?php

if ($argc == 4) {
	$one = intval($argv[1]);
	$ope = trim($argv[2]);
	$two = intval($argv[3]);
	if ($ope == '+')
		$result = $one + $two;
	else if ($ope == '-')
		$result = $one - $two;
	else if ($ope == '*')
		$result = $one * $two;
	else if ($ope == '/')
		$result = $one / $two;
	else if ($ope == '%')
		$result = $one % $two;
	else
		exit;
	print($result."\n");
}
else
	print("Incorrect Parameters\n");

?>
