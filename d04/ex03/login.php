<?php

session_start();
include 'auth.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET' AND auth($_GET['login'], $_GET['passwd'])) {
	$_SESSION['logged_on_user'] = $_GET['login'];
	echo("OK\n");
}
else {
	$_SESSION['logged_on_user'] = '';
	echo("ERROR\n");
}

?>
