<?php

$dir = '../private';
$file = 'passwd';
if ($_SERVER['REQUEST_METHOD'] == 'POST' AND $_POST['submit'] == 'OK' AND $_POST['login'] !== '' AND $_POST['passwd'] !== '')
	if (file_exists($dir) OR mkdir($dir)) {
		if (file_exists($dir.'/'.$file) AND $data = unserialize(file_get_contents($dir.'/'.$file)))
			foreach ($data as $user)
				if ($user['login'] == $_POST['login'])
					$find = 1;
		if (!$find AND $data[] = array('login' => $_POST['login'], 'passwd' => hash('sha512', $_POST['passwd'])))
			$ret = file_put_contents($dir.'/'.$file, serialize($data));
	}
if ($ret)
{
	header('Location: index.html');
	echo("OK\n");
}
else
	echo("ERROR\n");

?>
