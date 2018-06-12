<?php

$csv = 'todo.csv';

if ($_GET['del'] AND preg_match('/^todo\d+$/', $_GET['del'])) {
	$tab = array();
	if (file_exists($csv) AND $fd = fopen($csv, 'r')) {
		while ($gnl = fgetcsv($fd, 0, ';'))
			if ($_GET['del'] != 'todo'.$gnl[0])
				$tab[] = $gnl[1];
		fclose($fd);
	}
	$data = '';
	foreach ($tab as $id => $todo)
		$data .= $id.';'.$todo."\n";
	file_put_contents($csv, $data);
}

?>
