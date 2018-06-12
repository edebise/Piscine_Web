<?php

$file_items = 'items.csv';

function	item_save( $items ) {
	if ($items AND ksort($items))
	{
		$data = '';
		foreach ($items as $key => $item) {
			if ($key AND !$item['id'])
				$item['id'] = $key;
			$data .= implode(';', $item)."\n";
		}
		return (file_put_contents($GLOBALS['file_items'], $data));
	}
	return (FALSE);
}

function	item_load() {
	if (file_exists($GLOBALS['file_items']) AND $fd = fopen($GLOBALS['file_items'], 'r') AND $keys = fgetcsv($fd, 0, ';'))
	{
		$items[0] = $keys;
		while ($item = fgetcsv($fd, 0, ';'))
		{
			$item = array_combine($keys, $item);
			$items[$item['id']] = $item;
		}
		fclose($fd);
		ksort($items);
	}
	else
	{
		add_alert('Create items.csv');
		$items[0] = array('id', 'name', 'price', 'img', 'category');
		item_save( $items );
	}
	return ($items);
}

function	item_combine( array $keys, array $post ) {
	if ($keys AND $post)
	{
		foreach ($keys as $key) {
			$item[$key] = $post[$key];
		}
		$item['id'] = intval($item['id']);
		return ($item);
	}
	return (FALSE);
}

function	item_create( array $post ) {
	if ($post AND $items = item_load() AND $keys = $items[0] AND $new = item_combine($keys, $post)) {
		if ($new['id'] AND $items[$new['id']])
			return (add_alert('Cet \'id\' est déjà attribué.'));
		foreach ($new as $key => $value) {
			if ($value)
				$new[$key] = str_replace(array(';', "\r\n", "\n", "\r"), array(':', '<br>', '<br>', '<br>'), $value);
		}
		$items[] = $new;
		if (item_save($items))
			return (!add_alert('Article créé.'));
	}
	return (add_alert('Echec de la création.'));
}

function	item_edit( $id, array $post ) {
	if ($id AND $post AND $items = item_load() AND $keys = $items[0] AND $new = item_combine($keys, $post)) {
		if (!($new['id'] > 0))
			return (add_alert('Précisez un \'id\' valide.'));
		if ($id != $new['id'] AND $items[$new['id']])
			return (add_alert('Cet \'id\' est déjà attribué.'));
		foreach ($new as $key => $value) {
			if ($value)
				$new[$key] = str_replace(array(';', "\r\n", "\n", "\r"), array(':', '<br>', '<br>', '<br>'), $value);
		}
		$items[$id] = $new;
		if (item_save($items))
			return (!add_alert('Article modifié.'));
	}
	return (add_alert('Echec de la modification.'));
}

function	item_delete( $id ) {
	if ($id AND $items = item_load())
	{
		if (!$items[$id])
			return (add_alert('Cet \'id\' n\'est pas attribué.'));
		unset($items[$id]);
		if (item_save($items))
			return (!add_alert('Article supprimé.'));
	}
	return (add_alert('Echec de la suppression.'));
}

function	admin_print_item_form( $id, $item, $categories ) {
	print('<form method="POST" action="'.$_SERVER['REQUEST_URI'].'">');
	print('<fieldset><legend>'.($item ? $item['id'].' : '.$item['name'] : 'Créer un produit').'</legend>');
	if ($item)
		print('<input type="hidden" name="item" value="'.$item['id'].'">');
	print('<input type="number" name="id" placeholder="id (opt)" min="1" autocomplete="off"'.($item ? ' value="'.$item['id'].'">' : '>'));
	print('<input type="text" name="name" placeholder="Nom" required autocomplete="off"'.($item ? ' value="'.$item['name'].'">' : ' autofocus>'));
	print('<input type="number" name="price" placeholder="Prix" min="0" required autocomplete="off"'.($item ? ' value="'.$item['price'].'">' : '>'));
	print('<input type="text" name="img" placeholder="image (url)" required autocomplete="off"'.($item ? ' value="'.$item['img'].'">' : '>'));
	print('<select name="category">');
		print('<option value="">Catégorie...</option>');
	foreach ($categories as $key => $category) {
		print('<option value="'.$key.'"'.(($item AND $item['category'] == $key) ? ' selected>' : '>').$category.'</option>');
	}
	print('</select>');
	if ($item)
	{
		print('<input type="submit" name="submit" value="Modifier">');
		// print('<input type="submit" name="submit" value="Supprimer"'.onclick_confirm_delete().'>');
		print('<input type="image" name="submit" alt="Supprimer" src="http://www.icone-png.com/ico/19/18790.ico" width="18"'.onclick_confirm_delete().'>');
	}
	else
		print('<input type="submit" name="submit" value="Créer">');
	print('<br><textarea name="describe" placeholder="Description du produit ...">'.($item ? $item['describe'] : '').'</textarea>');
	print('</fieldset></form>');
}

?>
