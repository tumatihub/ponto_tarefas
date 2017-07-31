<?php
	require_once 'EstadoDeTarefa.php';
	require_once 'Tarefa.php';

	class TarefaAtivada implements EstadoDeTarefa {

		public function ativa(Tarefa $tarefa){

		}

		public function desativa(Tarefa $tarefa){
			$tarefa->atualizaDataDesativada(new DateTime('NOW'));
			$tarefa->setEstado(new TarefaDesativada);
		}

		public function getEstadoString(){
			return "ativada";
		}
	}
 ?>
