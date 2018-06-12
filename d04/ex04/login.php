<?php

session_start();
include 'auth.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' AND $_POST['submit'] == 'OK') {
	$_SESSION['logged_on_user'] = '';
	if (auth($_POST['login'], $_POST['passwd']))
		$_SESSION['logged_on_user'] = $_POST['login'];
}
if ($_SESSION AND $_SESSION['logged_on_user'] !== '') {
?>
	<title>42_Chat <?php echo("'".$_SESSION['logged_on_user']."'") ?> </title>
	<iframe name="chat" src="chat.php" width="100%" height="550px"></iframe>
	<iframe name="speak" src="speak.php" width="100%" height="50px"></iframe>
	<a href="logout.php"><button type="button">Logout</button></a>
<?php
}
else
	echo("ERROR\n");
