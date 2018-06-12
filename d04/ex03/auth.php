<?php

function	auth($login, $passwd)
{
	$dir = '../private';
	$file = 'passwd';
	if ($login !== '' AND $passwd !== '' AND file_exists($dir.'/'.$file) AND $data = unserialize(file_get_contents($dir.'/'.$file)))
		foreach ($data as $user)
			if ($user['login'] === $login AND $user['passwd'] === hash('sha512', $passwd))
				return(TRUE);
	return(FALSE);
}

?>
