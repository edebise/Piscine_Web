<?php

$csv = 'todo.csv';

$tab = array();
if (file_exists($csv) AND $fd = fopen($csv, 'r')) {
	while ($gnl = fgetcsv($fd, 0, ';')) {
		$tab[] = $gnl[1];
	}
	fclose($fd);
}

foreach (array_reverse($tab, true) as $id => $todo) {
	print('<div id="todo'.$id.'">'.$todo."</div>\n");
}

?>
