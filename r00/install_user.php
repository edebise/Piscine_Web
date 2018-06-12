<?php

$file_users = 'users.csv';

function	user_save( $users ) {
	if ($users AND ksort($users)) {
		$keys = array('login', 'admin', 'passwd');
		$glue = ';';
		$data = implode($glue, $keys)."\n";
		foreach ($users as $user) {
			$data .= $user['login'].$glue.($user['admin'] ? 1 : 0).$glue.$user['passwd']."\n";
		}
	}
	return ($data AND file_put_contents($GLOBALS['file_users'], $data));
}

function	user_load() {
	$glue = ';';
	if (file_exists($GLOBALS['file_users']) AND $fd = fopen($GLOBALS['file_users'], 'r') AND $keys = fgetcsv($fd, 0, $glue)) {
		while ($user = fgetcsv($fd, 0, $glue)) {
			if ($user = array_combine($keys, $user) AND $user['login'])
				$users[$user['login']] = $user;
		}
		fclose($fd);
	}
	if (!$users) {
		$users['login'] = array('login' => 'login', 'admin' => 1, 'passwd' => 'passwd');
		user_save( $users );
	}
	return ($users);
}

function	user_admin( $login ) {
	return ($users = user_load() AND $users[$login] AND $users[$login]['admin']);
}

function	user_auth( $login, $passwd ) {
	if (!$login)
		add_alert('Précisez un identifiant.');
	elseif (!$passwd)
		add_alert('Précisez un mot de passe.');
	elseif ($users = user_load())
	{
		if ($users[$login]['passwd'] == $passwd)	// hash();
			return($login);
		add_alert('Echec d\'authentification.');
	}
	return (FALSE);
}

function	user_create( array $new ) {
	if (!$new['login'] OR !preg_match($GLOBALS['preg'], $new['login']))
		return (add_alert('Entrez un identifiant valide: '.$GLOBALS['preg_title']));
	elseif (!$new['passwd'] OR !preg_match($GLOBALS['preg'], $new['passwd']))
		return (add_alert('Entrez un mot de passe valide: '.$GLOBALS['preg_title']));
	elseif ($users = user_load()) {
		if ($users[$new['login']])
			return (add_alert('Cet identifiant existe déjà.'));
		if (!$new['admin'] OR !$_SESSION['admin'])
			$new['admin'] = 0;
		// $new['passwd'] = hash('sha512', $new['passwd']);
		$users[$new['login']] = $new;
		if (user_save($users) AND !add_alert('Le compte \''.$new['login'].'\' a été créé avec succès.'))
			return ($new['login']);
	}
	return (add_alert('Echec de création de compte.'));
}

function	user_edit( $login, array $post ) {
	if (!$login)
		return (add_alert('Précisez un identifiant.'));
	elseif ($post['new_login'] AND !preg_match($GLOBALS['preg'], $post['new_login']))
		return (add_alert('Entrez un nouvel identifiant valide: '.$GLOBALS['preg_title']));
	elseif ($post['new_passwd'] AND !preg_match($GLOBALS['preg'], $post['new_passwd']))
		return (add_alert('Entrez un nouveau mot de passe valide: '.$GLOBALS['preg_title']));
	elseif ($post AND $users = user_load())
	{
		if ($post['new_login'] AND $users[$post['new_login']])
			return (add_alert('Cet identifiant existe déjà.'));
		$post['login'] = ($post['new_login'] ? $post['new_login'] : $login);
		$post['passwd'] = ($post['new_passwd'] ? $post['new_passwd'] : $users[$login]['passwd']);	// hash('sha512', $post['passwd']);
		$post['admin'] = (($_SESSION['admin'] AND $_SESSION['login'] != $login) ? $post['admin'] : $users[$login]['admin']);
		$users[$login] = $post;
		if (user_save($users) AND !add_alert('Le compte \''.$login.'\' a été modifié avec succès.'))
			return($post['login']);
	}
	return (add_alert('Echec de modification de compte.'));
}

function	user_delete( $login ) {
	if ($login AND $users = user_load() AND $users[$login])
	{
		unset($users[$login]);
		if (user_save($users) AND !add_alert('Le compte a été supprimé.'))
			return (TRUE);
	}
	add_alert('Echec de la suppression.');
	return (FALSE);
}

function	user_print_sidebar() {
	print('<ul>');
	if ($_SESSION['login'])
		print('<li><a href="login.php">Modification</a></li>
			<li><a href="login.php?log=delete">Suppression</a></li>
			<li><a href="login.php?log=out">Déconnexion</a></li>');
	else
		print('<li><a href="login.php">Connexion</a></li>
			<li><a href="login.php?log=new">Inscription</a></li>');
	print('</ul>');
}

function	user_print_form( $submit ) {
	print('<form method="POST" action="'.$_SERVER['REQUEST_URI'].'"><fieldset><legend>'.$submit.($_SESSION['login'] ? ' le compte <b>'.$_SESSION['login'].'</b>' : '').'</legend>');
	print('<input name="login" type="text" placeholder="Identifiant" required autocomplete="off" '.($_SESSION['login'] ? 'value="'.$_SESSION['login'].'" readonly>' : 'autofocus>'));
	if ($submit == 'Modifier') {
		print('<br>
			<input name="new_login"  type="text"     placeholder="Nouvel identifiant"   autofocus autocomplete="off">
			<input name="new_passwd" type="password" placeholder="Nouveau mot de passe" autofocus>');
	}
	print('<input name="passwd" type="password" placeholder="Mot de passe" required autofocus>');
	print('<input name="submit" type="submit" value="'.$submit.'"'.($submit == 'Supprimer' ? onclick_confirm_delete() : 0).'>');
	print('</fieldset></form>');
}

function	admin_print_user_form( array $user ) {
	print('<form method="POST" action="'.$_SERVER['REQUEST_URI'].'">');
	if ($user) {
		print('<input name="login"      type="text" placeholder="Identifiant" value="'.$user['login'].'" readonly>');
		print('<input name="new_login"  type="text" placeholder="Nouvel identifiant" autocomplete="off">');
		print('<input name="new_passwd" type="password" placeholder="Nouveau mot de passe">');
		print('<input name="admin"      type="checkbox"'.($user['admin'] ? ' checked' : '').'><span>admin</span>');
		print('<input name="submit"     type="submit" value="Modifier">');
		// print('<input name="submit"     type="submit" value="Supprimer"'.onclick_confirm_delete().'>');
		print('<input name="submit"     type="image"  alt="Supprimer" src="http://www.icone-png.com/ico/19/18790.ico" width="18"'.onclick_confirm_delete().'>');
	}
	else {
		print('<input name="login"  type="text"   placeholder="Identifiant" autocomplete="off" autofocus>');
		print('<input name="passwd" type="password" placeholder="Mot de passe">');
		print('<input name="admin"  type="checkbox"><span>admin</span>');
		print('<input name="submit" type="submit" value="Créer">');
	}
	print('</form>');
}

?>
