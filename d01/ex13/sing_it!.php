#!/usr/bin/php
<?php

function ft_split($str) {
	$tab = array_filter(explode(' ', str_replace(array("\n", "\r", "\t"), " ", $str)), strlen);
	return ($tab);
}

$tab = array();
foreach ($argv as $key => $arg)
	if ($key)
		$tab = array_merge($tab, ft_split($arg));
if (strtolower(implode(' ', $tab)) == 'mais pourquoi cette demo ?')
	print("Tout simplement pour qu'en feuilletant le sujet\non ne s'apercoive pas de la nature de l'exo..\n");

?>
