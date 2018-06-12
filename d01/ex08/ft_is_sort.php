<?php

function ft_is_sort(array $tab) {
	$sort = $tab;
	sort($sort);
	if ($tab === $sort OR $tab === array_reverse($sort))
		return (TRUE);
	return (FALSE);
}

?>
