#!/usr/bin/php
<?php

if ($argc == 2)
{
	$str = str_replace(array(" ", "\t"), "", $argv[1]);
	$i = 0;
	if ($str[$i] == '-' OR $str[$i] == '+')
		$i++;
	if ($str[$i] <= '0' OR $str[$i] >= '9')
		exit("Syntax Error\n");
	while ($str[$i] >= '0' AND $str[$i] <= '9')
		$i++;
	if (strpos("+-*/%", $str[$i]) === FALSE)
		exit("Syntax Error\n");
	$one = intval($str);
	$ope = $str[$i++];
	$two = intval(substr($str, $i));
	if ($str[$i] == '-' OR $str[$i] == '+')
		$i++;
	if ($str[$i] < '0' OR $str[$i] > '9')
		exit("Syntax Error\n");
	while ($str[$i] >= '0' AND $str[$i] <= '9')
		$i++;
	if ($str[$i])
		exit("Syntax Error\n");
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
