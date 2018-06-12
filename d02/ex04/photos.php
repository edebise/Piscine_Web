#!/usr/bin/php
<?php

if ($argc > 1 AND preg_match('/^http/', $website = $argv[1]) AND $page = @file_get_contents($website)) {
	$website = preg_replace('#/+$#', '', $website);
	// print('Web : '.$website."\n");
	if (preg_match_all('/<img .*src="(.+)"/iU', $page, $src)) {
		// print_r($src);
		$dir = preg_replace('#photos.php$#', '', $argv[0]);
		$dir .= preg_replace(array('#^https?:/+#', '#/+#'), array('', '/'), $website);
		// print('Dir : '.$dir."\n");
		foreach ($src[1] as $path) {
			if (!preg_match('/^http/', $path))
				$path = $website.'/'.$path;
			$path = str_replace(' ', '%20', $path);
			// print("\tPath: ".$path)."\n";
			if (preg_match('/[^\/]+$/', $path, $name))
				if ($data = @file_get_contents($path)) {
					$dest = $dir.'/'.$name[0];
					// print("\t\tDest: ".$dest."\n");
					if (is_dir($dir) OR mkdir($dir, 0755, true))
						@file_put_contents($dest, $data);
				}
		}
	}
}

?>
