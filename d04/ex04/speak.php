<?php

session_start();
$dir = '../private';
$file = 'chat';
if ($_SESSION AND $_SESSION['logged_on_user'] !== '') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST' AND $_POST['msg'] !== '' AND $_POST['submit'] == 'OK') {
		$new = array(	'login' => $_SESSION['logged_on_user'], 
						'time' => time(), 
						'msg' => $_POST['msg'], 
						'color' => '#'.substr(hash(md2, $_SESSION['logged_on_user']), 3, 6));
		if ($new AND file_exists($dir) OR mkdir($dir))
			if ($fd = fopen($dir.'/'.$file, 'c+') AND flock($fd, LOCK_EX)) {
				$data = unserialize(fgets($fd));
				$data[] = $new;
				fseek($fd, 0);
				fwrite($fd, serialize($data));
				flock($fd, LOCK_UN);
				fclose($fd);
			}
	}
?>
<html><head><script type="text/javascript">top.frames['chat'].location = 'chat.php';</script></head><body>
<form method="POST" name="speak" action="speak.php">
	Message: <input type="text" name="msg" placeholder=" ..." autocomplete="off" autofocus required />
	<input type="submit" name="submit" value="OK" />
</form></body></html>
<?php
}
else
	echo("ERROR\n");
