<?php

require_once('install.php');
session_start();

if (!$_SESSION['login'] OR !$_SESSION['admin'])
	exit_header('index.php');
elseif ($_GET['form'] == 'items')
{
	if ($_POST['submit'] == 'Créer')
		item_create($_POST);
	elseif ($_POST['submit'] == 'Modifier')
		item_edit($_POST['item'], $_POST);
	elseif ($_POST['submit'] == 'Supprimer' OR $_POST['submit_x'] OR $_POST['submit_y'])
		item_delete($_POST['item']);
}
elseif ($_GET['form'] == 'categories')
{
	if ($_POST['submit'] == 'Créer')
		category_edit('', $_POST['new_name']);
	elseif ($_POST['submit'] == 'Modifier' AND $_POST['new_name'])
		category_edit($_POST['id'], $_POST['new_name']);
	elseif ($_POST['submit'] == 'Supprimer')
		category_edit($_POST['id'], '');
}
elseif ($_GET['form'] == 'users')
{
	if ($_POST['submit'] == 'Créer')
		user_create($_POST);
	elseif ($_POST['submit'] == 'Modifier')
		user_edit($_POST['login'], $_POST);
	elseif ($_POST['submit'] == 'Supprimer' OR $_POST['submit_x'] OR $_POST['submit_y'])
		user_delete($_POST['login']);
}
if ($_POST)
	exit_header($_SERVER['REQUEST_URI']);

// print('<pre>');print_r($_SESSION['alert']);print('</pre>');

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="favicon.png">
	<link rel="stylesheet" type="text/css" href="shop.css">
	<title>Minishop_42 Admin</title>
</head>
<body>
	<?php print_header(); ?>
	<main>
		<div class="sidebar">Sidebar
			<ul>
				<li><a href="admin.php?form=items">Articles</a></li>
				<li><a href="admin.php?form=categories">Catégories</a></li>
				<li><a href="admin.php?form=users">Utilisateurs</a></li>
			</ul>
		</div>
		<div class="content"><?php

			if ($_GET['form'] == 'users' AND $users = user_load()) {
				admin_print_user_form(array());
				foreach ($users as $user) {
					if ($user['login'] != $_SESSION['login'])
						admin_print_user_form($user);
				}
			}
			elseif ($_GET['form'] == 'categories' AND $categories = category_load()) {
				admin_print_category_form('', '');
				foreach ($categories as $key => $name) {
					admin_print_category_form($key, $name);
				}
			}
			elseif ($_GET['form'] == 'items' AND $items = item_load() AND $categories = category_load()) {
				admin_print_item_form('new', '', $categories);
				foreach ($items as $key => $item) {
					if ($key)
						admin_print_item_form($key, $item, $categories);
				}
			}

		?></div>
	</main>
	<footer>edebise@student.42.fr</footer>

<?php print_alert_div(); ?>

</body>
</html>
