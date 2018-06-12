<?php

if ($_GET['action'] AND $_GET['name']) {
	if ($_GET['action'] == 'set' AND $_GET['value'])
		setcookie($_GET['name'], $_GET['value'], time() + 60*60*24 );
	else if ($_GET['action'] == 'get' AND $_COOKIE[$_GET['name']])
		echo($_COOKIE[$_GET['name']]."\n");
	else if ($_GET['action'] == 'del')
		setcookie($_GET['name']);
}

?>
