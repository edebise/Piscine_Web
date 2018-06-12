$(document).ready(function(){
	cook_load();

	$('#submit').click(function(){
		mk_todo( prompt('Ajouter un tâche :', 'Description de la tâche.') );
		cook_save();
	});

	function mk_todo( str ){
		if (str && str.trim().length)
			$('<div>' + str.trim().replace(/</g, '< ').replace(/>/g, ' >') + '</div>').prependTo('#ft_list').click(rm_todo);
	}

	function rm_todo(){
		if (confirm('Voulez vous vraiment supprimer cette tâche ?')) {
			$(this).remove();
			cook_save();
		}
	}

	function cook_load(){
		var cook = document.cookie;

		cook = cook.match(/todo=[^;]*/);
		cook ? cook = unescape(cook[0].substr(5).trim()) : 0;
		if (cook)
			$(cook).prependTo('#ft_list').click(rm_todo);
	}

	function cook_save(){
		document.cookie = 'todo=' + escape($('#ft_list').html());
	}
});
