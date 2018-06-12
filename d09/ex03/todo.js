$(document).ready(function(){
	load_todo();

	$('#submit').click(function(){
		add_todo( prompt('Ajouter un tâche :', 'Description de la tâche.') );
	});

	function	load_todo() {
		$.get('select.php', function(data){
			$('#ft_list').html(data);
			$('#ft_list div').click(rm_todo);
		});
	}

	function	add_todo( str ) {
		$.get('insert.php', {new:str}, function(){
			load_todo();
		});
	}

	function	rm_todo(){
		if (confirm('Voulez vous vraiment supprimer cette tâche ?')) {
			// console.log($(this).attr('id'));
			$.get('delete.php', {del:$(this).attr('id')}, function() {
				load_todo();
			});
		}
	}
});
