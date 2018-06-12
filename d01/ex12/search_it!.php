#!/usr/bin/php
<?php

if ($argc > 2 AND $key = $argv[1].':') {
	foreach ($argv as $k => $arg)
		if ($k > 1 AND strpos($arg, $key) === 0)
			exit(substr($arg, strlen($key))."\n");
}

?>
