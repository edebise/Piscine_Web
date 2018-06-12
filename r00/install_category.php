<?php

$file_categories = 'categories.csv';

function	category_save( $categories ) {
	return (ksort($categories) AND file_put_contents($GLOBALS['file_categories'], serialize($categories)));
}

function	category_load() {
	if (!file_exists($GLOBALS['file_categories']) OR !$categories = unserialize(file_get_contents($GLOBALS['file_categories'])))
	{
		$categories[] = 'Indéfini';
		category_save($categories);
	}
	return ($categories);	
}

function	category_edit( $id, $name ) {
	if ($id AND !($id > 0))
		return (add_alert('Précisez un \'id\' de catégorie valide'));
	elseif ($name AND !preg_match($GLOBALS['preg'], $name))
		return (add_alert('Entrez un nom valide: '.$GLOBALS['preg_title']));
	if (($id OR $name) AND $categories = category_load())
	{
		if ($id AND $name)
			$categories[$id] = $name;
		elseif (!$id AND $name)
			$categories[] = $name;
		else
			unset($categories[$id]);
		if (category_save($categories) AND !add_alert('Catégorie éditée avec succès.'))
			return (TRUE);
	}
	return (add_alert('Edition impossible de catégorie'));
}

function	admin_print_category_form( $id, $category ) {
	print('<form method="POST" action="'.$_SERVER['REQUEST_URI'].'">');
	if ($category)
		print('<input type="number" name="id" value="'.$id.'" readonly>
			<input type="text" name="name" value="'.$category.'" readonly>');
	if ($id)
		print('<input type="text" name="new_name" placeholder="Nouveau nom" autocomplete="off" autofocus>');
	elseif (!$id AND !$category)
		print('<input type="text" name="new_name" placeholder="Nouvelle catégorie" autocomplete="off" autofocus>');
	if ($id AND $category)
	{
		print('<input type="submit" name="submit" value="Modifier">');
		print('<input type="submit" name="submit" value="Supprimer"'.onclick_confirm_delete().'>');
	}
	elseif (!$id AND !$category)
		print('<input type="submit" name="submit" value="Créer">');
	elseif (!$id AND $category)
		print('<input type="button" name="submit" value="Non modifiable">');
	print('</form>');
}

?>
