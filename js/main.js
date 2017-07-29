$(document).ready(function(){
	carregaTarefas();
	$("#adiciona").change(adicionaNovaTarefa);
	$('#relatorio-button').click(geraRelatorio);

});

function atualizaEventos(id) {
	tarefa = $("div#"+id);
	tarefa.find(".remover").click(removeTarefa);
	tarefa.find("input").change(mudaNomeTarefa);
	tarefa.find(".estado").click(mudaEstadoTarefa);
}

function tempoEmAtividadeString(tmp) {
	anos = tmp['y'] != 0 ? tmp['y']+' anos': '';
	meses = tmp['m'] != 0 ? tmp['m']+' meses ': '';
	dias = tmp['d'] != 0 ? tmp['d']+' dias ': '';
	horas = tmp['h']+':';
	min = tmp['i']+':';
	seg = tmp['s']+'h';
	return anos+meses+dias+horas+min+seg;
}

function criaNovoElementoTarefa(id, nome, estado, tempoEmAtividadeString){
	ativarOuDesativar = estado == 'ativada' ? 'fa-stop' : 'fa-play';
	return `
		<div id="${id}" class="tarefa ${estado}">
			<input type="text" value="${nome}">
			<span id="tempoEmAtividade">${tempoEmAtividadeString}</span>
			<div class="icons">
				<i class="fa ${ativarOuDesativar} estado" aria-hidden="true"></i>
				<i class="fa fa-trash remover" aria-hidden="true"></i>
			</div>
		</div>
	`;
}

function insereElementoTarefa(id, elemento){
	$(elemento).insertBefore("#menu");
	atualizaEventos(id);
}

function carregaTarefas(){
	$.post("interfaceGerenciador.php", {
    	acao: "pegaTodasAsTarefas"
    }, function(data, status){
    	data.forEach(function(item){
    		insereElementoTarefa(
    			item['id'],
    			criaNovoElementoTarefa(
    				item['id'],
    				item['nome'],
    				item['estado'],
    				tempoEmAtividadeString(item['tempoEmAtividade'])
    			)
    		);
    	});
    }, "json");
}

function adicionaNovaTarefa(){
	nomeTarefa = $(this).val();
	$(this).val('');
	$(this).focus();
    $.post("interfaceGerenciador.php", {
    	acao: "adicionaTarefa",
    	nome: nomeTarefa
    }, function(data, status){
    	insereElementoTarefa(data['id'], criaNovoElementoTarefa(data['id'], nomeTarefa, 'desativada', '00:00:00h'));
    	salvaGerenciador();
    }, "json");
}

function removeTarefa(event){
	event.preventDefault();
	id = $(this).parent().parent().attr('id');
    $.post("interfaceGerenciador.php", {
    	acao: "removeTarefa",
    	id: id
    }, function(data, status){
    	$("div#"+id).remove();
    	salvaGerenciador();
    });
}

function mudaNomeTarefa() {
	id = $(this).parent().attr('id');
	nome = $(this).parent().find('input').val();
    $.post("interfaceGerenciador.php", {
    	acao: "mudaNomeTarefa",
    	id: id,
    	nome: nome
    }, function(data, status){
    	$('#adiciona').focus();
    	salvaGerenciador();
    });
}

function desativaTarefa(id) {
	$.post("interfaceGerenciador.php", {
    	acao: "desativaTarefa",
    	id: id
    }, function(data, status){
    	tarefaDiv = $('div#'+id);
    	tarefaDiv.removeClass('ativada');
    	tarefaDiv.addClass('desativada');
    	tarefaDiv.find('.estado').toggleClass('fa-play fa-stop');
    	tarefaDiv.find('#tempoEmAtividade').text(tempoEmAtividadeString(data['tempoEmAtividade']));
    	salvaGerenciador();
    }, "json");
}

function pegaIdAtiva() {
	return $('.ativada').attr('id');
}

function ativaTarefa(id) {
	idAtiva = pegaIdAtiva();
	if ( idAtiva ) {
		desativaTarefa(idAtiva);
	}
	$.post("interfaceGerenciador.php", {
    	acao: "ativaTarefa",
    	id: id
    }, function(data, status){
    	tarefaDiv = $('div#'+id);
    	tarefaDiv.removeClass('desativada');
    	tarefaDiv.addClass('ativada');
    	tarefaDiv.find('.estado').toggleClass('fa-play fa-stop');
    	salvaGerenciador();
    });
}

function mudaEstadoTarefa(event) {
	event.preventDefault();
	id = $(this).parent().parent().attr('id');
	console.log(id);
	if ( $(this).parent().parent().hasClass('ativada') ) {
		desativaTarefa(id);
	} else if ( $(this).parent().parent().hasClass('desativada') ) {
		ativaTarefa(id);
	}
}

function salvaGerenciador() {
	console.log('salvando');
	$.post("interfaceGerenciador.php", {
    	acao: "salvaGerenciador"
    }, function(data, status) {
    	console.log(data);
    });
}

function insereElementoRelatorio(titulo, tempo) {
	element = "<spam>- "+titulo+"</spam> - <spam>"+tempo+" h</spam><br/>";
	$('section.relatorio').append(element);
}

function geraRelatorio(event) {
	event.preventDefault();
	$.post("interfaceGerenciador.php", {
    	acao: "geraRelatorio"
    }, function(data, status){
			data.forEach(function(item){
				insereElementoRelatorio(item['titulo'], item['tempo']);
			});
    }, "json");
}
