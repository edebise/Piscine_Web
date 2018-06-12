#!/usr/bin/php
<?php

if ($argc == 2) {
	while ($new = fgetcsv(STDIN, 0,';'))
		if (sizeof($new) == 4 AND strlen($new[0]) AND strlen($new[1]) AND is_numeric($new[1]) AND strlen($new[2]))
			$tab[$new[0]][$new[2]] = intval($new[1]);
	if ($tab)
		ksort($tab);
	if (sizeof($tab) AND $argv[1] === 'moyenne') {
		$sum = 0;
		$nb_note = 0;
		foreach ($tab as $user => $tmp)
			foreach ($tmp as $correcteur => $value)
				if ($correcteur !== 'moulinette') {
					$sum += $value;
					$nb_note++;
				}
		if ($nb_note)
			print($sum/$nb_note."\n");
	}
	else if (sizeof($tab) AND $argv[1] === 'moyenne_user')
		foreach ($tab as $user => $tmp) {
			$sum = 0;
			$nb_noteur = 0;
			foreach ($tmp as $noteur => $value)
				if ($noteur !== 'moulinette') {
					$sum += $value;
					$nb_noteur++;
				}
			if ($nb_noteur)
				print($user.':'.$sum/$nb_noteur."\n");
		}
	else if (sizeof($tab) AND $argv[1] === 'ecart_moulinette')
		foreach ($tab as $user => $tmp) {
			$sum = 0;
			$nb_noteur = 0;
			if (array_key_exists('moulinette', $tmp))
				foreach ($tmp as $noteur => $value)
					if ($noteur !== 'moulinette') {
						$sum += $value;
						$nb_noteur++;
					}
			if ($nb_noteur)
				print($user.":".($sum/$nb_noteur-$tmp['moulinette'])."\n");
		}
}

?>
