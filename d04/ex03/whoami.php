<?php

session_start();
if ($_SESSION AND $_SESSION['logged_on_user'] !== '')
	echo($_SESSION['logged_on_user']."\n");
else
	echo("ERROR\n");

?>
