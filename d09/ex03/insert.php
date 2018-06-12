<?php

$csv = 'todo.csv';

$tab = array();
if (file_exists($csv) AND $fd = fopen($csv, 'r')) {
	while ($gnl = fgetcsv($fd, 0, ';')) {
		$tab[] = $gnl[1];
	}
	fclose($fd);
}

if (isset($_GET['new']) AND $_GET['new'] !== '') {
	$tab[] = str_replace(';', ':', $_GET['new']);
	$data = '';
	foreach ($tab as $id => $todo) {
		$data .= $id.';'.$todo."\n";
	}
	file_put_contents($csv, $data);
}

?>
