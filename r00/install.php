<?php

require_once('install_user.php');
require_once('install_item.php');
require_once('install_category.php');

$preg = '/^\w+$/';
$pattern = '^\w+$';
$preg_title = 'Caractères alphanumérique (A-Za-z0-9_).';

function	exit_header( $page ) {
	header('Location:'.$page);
	exit;
}

function	add_alert( $new_alert ) {
	$_SESSION['alert'][] = $new_alert;
	return (FALSE);
}

function	print_alert_div() {
	$str = '';
	if ($_SESSION['alert'])
		foreach ($_SESSION['alert'] as $alert) {
			$str .= '<div class="alert">'.$alert.'</div>';
		}
	$_SESSION['alert'] = array();
	if ($str)
		print('<div class="fixed">'.$str.'</div>');
}

function	print_alert_script() {
	if ($_SESSION['alert'])
		foreach ($_SESSION['alert'] as $alert) {
			print('<script> alert("'.$alert.'"); </script>');
		}
	$_SESSION['alert'] = array();
}

function	print_header() {
	$categories = category_load();
	print('<header><div class="log_link">');
	if ($_SESSION['login'])
		print('<a href="login.php"><b>'.$_SESSION['login'].'</b></a>
			'.($_SESSION['admin'] ? '<a href="admin.php">admin</a>' : '').'
			<a href="login.php?log=out">déconnexion</a></div>');
	else
		print('<a href="login.php">connexion</a></div>');
	print('<div class="website"><a href="index.php">Minishop_42</a></div>
		<ul class="menu">
			<a href="index.php"><li class="m0">Accueil</li></a>
			<li class="m0">Catégorie<ul>
				<a href="index.php?category=all"><li>Toutes les catégories</li></a>');
	foreach ($categories as $key => $category) {
		if ($key)
			print('<a href="index.php?category='.$key.'"><li>'.$category.'</li></a>');
	}
	print('</ul></li>
			<a href="index.php?basket=view"><li class="m0">Panier</li></a>
		</ul></header>');
}

function	onclick_confirm_delete() {
	return(' onclick="this.name = (confirm(\'Supprimer ?\') ? \'submit\' : \'cancel\');"');
}

function	shop_sort_by_price( array $item_A, array $item_B ) {
	if ($item_A['price'] == $item_B['price'])
		return (strcasecmp($item_A['name'], $item_B['name']));
	if ($_GET['sort'] == 'price_increase')
		return ($item_A['price'] < $item_B['price'] ? -1 : 1);
	return ($item_A['price'] < $item_B['price'] ? 1 : -1);
}

function	shop_sort_by_name( array $item_A, array $item_B ) {
	if ($_GET['sort'] == 'name_increase')
		return (strcasecmp($item_A['name'], $item_B['name']));
	return (-strcasecmp($item_A['name'], $item_B['name']));
}

function	shop_print_sidebar() {
	print('<ul>');
	print('<li><a href="index.php?category=all">Tous les produits</a></li>');
	foreach ($_SESSION['categories'] as $key => $category) {
		if ($key)
			print('<li><a href="index.php?category='.$key.'">'.$category.'</a></li>');
	}
	print('</ul>');
}

function	shop_print_items() {
	if ($_GET['basket']) {
		$_SESSION['basket'] ? basket_print_items() : print('<br><p>Votre panier est vide.</p>');
	}
	elseif ($_GET['item'] AND $_SESSION['items'][$_GET['item']])
		shop_print_item_page($_SESSION['items'][$_GET['item']]);
	elseif ($_GET['category'] AND $_SESSION['categories'][$_GET['category']]) {
		shop_display_sorting();
		shop_print_category($_GET['category'], -1);
	}
	elseif ($_GET['category']) {
		shop_display_sorting();
		shop_print_category('', -1);
	}
	else {
		shop_display_sorting();
		foreach ($_SESSION['categories'] as $key => $category) {
			if ($key)
				shop_print_category($key, 4);
		}
	}
}

function	shop_display_sorting() {
	print('<form method="post" action="'.$_SERVER['REQUEST_URI'].'">');
	print(	'<select name="sort">');
	print(		'<option value="">Trier par ...</option>');
	print(		'<option value="price_increase">Prix croissants</option>');
	print(		'<option value="price_decrease">Prix décroissants</option>');
	print(		'<option value="name_increase">Noms croissants</option>');
	print(		'<option value="name_decrease">Noms décroissants</option>');
	print(	'</select>');
	print(	'<input type="submit" name="submit" value="Trier">');
	print('</form>');
}

function	shop_print_category( $category, $nb ) {
	if ($category)
		print('<h4><a href="index.php?category='.$category.'">Catégorie: '.$_SESSION['categories'][$category].'</a>'.$category.'</h4>');
	foreach ($_SESSION['items'] as $item) {
		if ($nb AND (!$category OR $item['category'] == $category))
		{
			$nb--;
			shop_print_one_item($item);
		}
	}
}

function	shop_print_one_item( $item ) {
	if ($item['id'])
		print('<div class="item">
			<a href="index.php?item='.$item['id'].'">
			<img src="'.$item['img'].'" alt="'.$item['name'].'" title="'.$item['name'].'">
			<p>'.$item['name'].' - '.$item['price'].'€</p></a></div>');
}

function	old_shop_print_item_page( $item ) {
	if ($item['id'])
		print('<div class="item_page">
			<img src="'.$item['img'].'" alt="'.$item['name'].'" title="'.$item['name'].'">
			<p>'.$item['name'].' - '.$item['price'].'€</p>
			<form method="POST" action="'.$_SERVER['REQUEST_URI'].'">
			<input name="id"       type="hidden"  value="'.$item['id'].'">
			<input name="quantity" type="number"  value="1" min="1">
			<input name="submit"   type="submit"  value="Ajouter au panier">
			</form></div>');
}

function	tab_shop_print_item_page( $item ) {
	if ($item['id'])
		print('<table class="item_page"><tr>
			<td><img src="'.$item['img'].'" alt="'.$item['name'].'" title="'.$item['name'].'"></td>
			<td>'.$item['describe'].'</td></tr></table>
			<form method="POST" action="'.$_SERVER['REQUEST_URI'].'">
			<input name="id"       type="hidden"  value="'.$item['id'].'">
			<input name="quantity" type="number"  value="1" min="1">
			<input name="submit"   type="submit"  value="Ajouter au panier">
			</form></div>');
}

function	shop_print_item_page( $item ) {
	if ($item['id'])
		print('<fieldset><legend><h3>'.$item['name'].'</h3></legend><div class="item_page"><img src="'.$item['img'].'" alt="'.$item['name'].'" title="'.$item['name'].'"><p>'.$item['describe'].'</p>
			<form method="POST" action="'.$_SERVER['REQUEST_URI'].'">
			<input name="id"       type="hidden"  value="'.$item['id'].'">
			<span>'.$item['price'].'€</span>
			<input name="quantity" type="number"  value="1" min="1">
			<input name="submit"   type="submit"  value="Ajouter au panier">
			</form></div></fieldset>');
}

function	basket_add_item( $id, $quantity ) {
	if ($_SESSION['basket'] AND $_SESSION['basket'][$id])
		$_SESSION['basket'][$id] += $quantity;
	else {
		$_SESSION['basket'][$id] = $quantity;
		add_alert('Le produit a été ajouté au panier');
	}
	if ($_SESSION['basket'][$id] <= 0)
		unset($_SESSION['basket'][$id]);
}

function	basket_print_items() {
	if ($_SESSION['basket']) {
		$bill = 0;
		print('<br><table class="basket"><tr><th class="left">Article</th><th>Prix unitaire</th><th>Quantité</th><th class="right">Somme</th></tr>');
		foreach ($_SESSION['basket'] as $id => $quantity) {
			if ($quantity > 0) {
				print('<tr>
					<td class="left"><a href="index.php?item='.$id.'">'.$_SESSION['items'][$id]['name'].'</a></td>
					<td>'.$_SESSION['items'][$id]['price'].'€</td>
					<td><form method="post" action="'.$_SERVER['REQUEST_URI'].'">
						<input name="id" type="hidden" value="'.$id.'">
						<input name="submit" type="submit" value="-"><span>'.$quantity.'</span><input name="submit" type="submit" value="+"></form></td>
					<td class="right">'.($_SESSION['items'][$id]['price'] * $quantity).'€</td>
					</tr>');
				$bill += ($_SESSION['items'][$id]['price'] * $quantity);
			}
		}
		print('<tr><th class="right hidden" colspan="3">Total </th><th class="right">'.$bill.'€</th></tr>
			<th class="right hidden" colspan="4"><form method="post" action="'.$_SERVER['REQUEST_URI'].'"><input name="submit" type="submit" value="Commander"></form></th></table>');
	}
}

?>
