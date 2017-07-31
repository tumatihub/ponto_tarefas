<?php
	require_once 'EstadoDeTarefa.php';
	require_once 'Tarefa.php';

	class TarefaDesativada implements EstadoDeTarefa {

		public function ativa(Tarefa $tarefa){
			$tarefa->atualizaDataAtivada(new DateTime('NOW'));
			$tarefa->setEstado(new TarefaAtivada);
		}

		public function desativa(Tarefa $tarefa){

		}

		public function getEstadoString(){
			return "desativada";
		}
	}
 ?>
