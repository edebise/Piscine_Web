function get_todo() {
	mk_todo( prompt('Ajouter une tâche :', 'Description de la tâche.') );
	cook_save();
}

function mk_todo( str ) {
	if (str && str.trim().length) {
		var list = document.getElementById('ft_list');
		var todo = document.createElement('DIV');
		todo.appendChild(document.createTextNode(str.trim()));
		todo.onclick = rm_todo;
		list.insertBefore(todo, list.childNodes[0]);
	}
}

function rm_todo() {
	if (confirm('Voulez vous vraiment supprimer cette tâche ?'))
		this.parentNode.removeChild(this);
	cook_save();
}

function cook_load() {
	var cook = document.cookie;

		// console.log('LoadCook:' + cook);
	if (/todo=/.test(cook)) {
		var tab = cook.split(';');
		for (key in tab)
			if (/^\s*todo=/.test(tab[key]))
				cook = tab[key].trim();
		tab = cook.substr(5).split('&&');
		for (var i = tab.length - 1; i >= 0; i--)
			mk_todo(unescape(tab[i]));
	}
}

function cook_save() {
	var cook = '';
	var divList = document.getElementById('ft_list').getElementsByTagName('DIV');

	for (key in divList)
		if (key < divList.length)
			cook += (key > 0 ? '&&' : '') + escape(divList[key].textContent);
	document.cookie = 'todo=' + cook;
		console.log('Save_Cook:' + cook);
		// console.log('CheckCook:' + document.cookie);
}
