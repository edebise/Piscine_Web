<?php

require_once('install.php');
session_start();
// shop_item_init();

$_SESSION['items'] = item_load();
$_SESSION['categories'] = category_load();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['sort'] == 'price_increase' OR $_POST['sort'] == 'price_decrease')
		usort($_SESSION['items'], shop_sort_by_price);
	elseif ($_POST['sort'] == 'name_increase' OR $_POST['sort'] == 'name_decrease')
		usort($_SESSION['items'], shop_sort_by_name);
	elseif ($_POST['submit'] == 'Ajouter au panier' AND $_POST['id'] AND $_SESSION['items'][$_POST['id']] AND $_POST['quantity'] > 0)
		basket_add_item($_POST['id'], $_POST['quantity']);
	elseif ($_POST['submit'] == '+' OR $_POST['submit'] == '-')
		basket_add_item($_POST['id'], ($_POST['submit'] == '+' ? 1 : -1));
	elseif ($_POST['submit'] == 'Commander') {
		if (!$_SESSION['login'])
			exit_header('login.php');
		add_alert('Votre commande est enregistrée. Pensez à vous déconnecter.');
		$_SESSION['basket'] = array();
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
	<?php print_header(); ?>
	<main>
		<div class="sidebar">Sidebar<?php shop_print_sidebar(); ?></div>
		<div class="content"><?php shop_print_items(); ?></div>
	</main>
	<footer>edebise@student.42.fr</footer>

<?php print_alert_div(); ?>

</body>
</html>
