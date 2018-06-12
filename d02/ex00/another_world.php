#!/usr/bin/php
<?php

// if ($argc > 1)
	// print(preg_replace(array('/\s+/', '/^\s/', '/\s+$/'), array(' '), $argv[1])."\n");
if ($argc > 1)
	print(preg_replace(array('/[ \t]+/', '/^ /m', '/ $/m'), array(' '), $argv[1])."\n");

?>
