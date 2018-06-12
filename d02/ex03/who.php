#!/usr/bin/php
<?php

if ($fd = fopen('/var/run/utmpx', 'r'))
{
	while ($bin = fread($fd, 628))
	{
		$new = unpack('a256user/a4id/a32line/ipid/itype/iwhen', $bin);
		if ($new['type'] == 7)
			$list[$new['line']] = $new;
	}
	ksort($list);
	date_default_timezone_set('Europe/Paris');
	foreach ($list as $tab)
		print_r($tab['user']."\t ".$tab['line']."  ".date('M d H:i', $tab['when'])."\n");
}

?>
