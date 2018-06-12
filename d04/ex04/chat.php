<?php

session_start();
$dir = '../private';
$file = 'chat';
date_default_timezone_set('Europe/Paris');
if ($_SESSION AND $_SESSION['logged_on_user'] !== '') {
	if (file_exists($dir) OR mkdir($dir))
		if (file_exists($dir.'/'.$file) AND $fd = fopen($dir.'/'.$file, 'r') AND flock($fd, LOCK_SH)) {
			$data = unserialize(fgets($fd));
			flock($fd, LOCK_UN);
			fclose($fd);
		}
	if ($data)
		foreach ($data as $key => $mail)
			echo('<p style="margin:3px;color:'.$mail['color'].'">['.date('H:i', $mail['time']).'] <b>'.$mail['login']."</b>: ".$mail['msg']."</p>\n");
	echo('<p style="margin:3px;color:#d3d3d3">['.date('H:i', time())."] <b id=\"End\">".$_SESSION['logged_on_user']."</b>: ...</p>\n");
}
else
	echo("ERROR\n");

?>
