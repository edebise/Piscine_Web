<?php

require_once('install.php');
session_start();

if (!$_SESSION['login'] AND $_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['submit'] == 'Connexion' AND $_SESSION['login'] = user_auth($_POST['login'], $_POST['passwd'])) {
		$_SESSION['admin'] = user_admin($_SESSION['login']);
		exit_header('index.php');
	}
	elseif ($_POST['submit'] == 'Créer mon compte' AND $_SESSION['login'] = user_create($_POST))
		exit_header('index.php');
}
elseif ($_SESSION['login']) {
	if ($_GET['log'] == 'out') {
		$alert = $_SESSION['alert'];
		$_SESSION = array();
		$_SESSION['alert'] = $alert;
		exit_header('index.php');
	}
	elseif ($_POST['submit'] == 'Supprimer' AND $_GET['log'] == 'delete') {
		if ($_POST['login'] == $_SESSION['login'] OR add_alert('Vous n\'avez pas les droits sur ce compte.'))
			if (user_auth($_POST['login'], $_POST['passwd']) AND user_delete($_POST['login']))
				exit_header('login.php?log=out');
	}
	elseif ($_POST['submit'] == 'Modifier' AND $_POST) {
		if ($_POST['login'] == $_SESSION['login'] OR add_alert('Vous n\'avez pas les droits sur ce compte.'))
			if (user_auth($_POST['login'], $_POST['passwd']) AND $ret = user_edit($_POST['login'], $_POST))
				$_SESSION['login'] = $ret;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="favicon.png">
	<link rel="stylesheet" type="text/css" href="shop.css">
	<title>Minishop_42</title>
</head>
<body>
	<header><?php print_header(); ?></header>
	<main>
		<div class="sidebar">Sidebar<?php user_print_sidebar(); ?></div>
		<div class="content"><?php

			if ($_SESSION['login'])
			{
				if ($_GET['log'] == 'delete')
					user_print_form('Supprimer');
				else
					user_print_form('Modifier');
			}
			elseif ($_GET['log'] == 'new')
				user_print_form('Créer mon compte');
			else
				user_print_form('Connexion');

		?></div>
	</main>
	<footer>edebise@student.42.fr</footer>

<?php print_alert_div(); ?>

</body>
</html>
