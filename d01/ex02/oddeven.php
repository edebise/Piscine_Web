#!/usr/bin/php
<?php

function is_valid($str)
{
	$len = strlen($str);
	$i = 0;
	if ($str[$i] == '-' OR $str[$i] == '+')
		$i++;
	while ($i < $len - 1 AND $str[$i] >= '0' AND $str[$i] <= '9')
		$i++;
	if ($str[$i] >= '0' AND $str[$i] <= '9')
		return ($str[$i] % 2 ? 1 : 2);
	return (FALSE);
}

while ((print("Entrez un nombre: ")) AND ($gnl = fgets(STDIN)))
{
	$gnl = trim($gnl);
	if ($gnl != NULL AND $ret = is_valid($gnl))
		print($ret == 1 ? "Le chiffre $gnl est Impair\n" : "Le chiffre $gnl est Pair\n");
	else
	 	print("'$gnl' n'est pas un chiffre\n");
}

?>
