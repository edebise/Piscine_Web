<?php

$dir = '../private';
$file = 'passwd';
if ($_SERVER['REQUEST_METHOD'] == 'POST' AND $_POST['submit'] == 'OK'
	AND $_POST['login'] !== '' AND $_POST['oldpw'] !== '' AND $_POST['newpw'] !== ''
	AND file_exists($dir.'/'.$file) AND $data = unserialize(file_get_contents($dir.'/'.$file)))
	{
		foreach ($data as $key => $user)
			if ($user['login'] === $_POST['login'] AND $user['passwd'] === hash('sha512', $_POST['oldpw']))
			{
				$data[$key]['passwd'] = hash('sha512', $_POST['newpw']);
				$ret = file_put_contents($dir.'/'.$file, serialize($data));
				break;
			}
	}
if ($ret)
{
	header('Location: index.html');
	echo("OK\n");
}
else
	echo("ERROR\n");

?>
