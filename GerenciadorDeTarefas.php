<?php 
	require_once 'Tarefa.php';
	require_once 'EstadoDeTarefa.php';
	require_once 'TarefaAtivada.php';
	require_once 'TarefaDesativada.php';

	class GerenciadorDeTarefas {

		private $listaDeTarefas;

		public function __construct() {
			$this->listaDeTarefas = array();	
		}

		public function retornaIndiceUsandoId($id) {
			$keys = array_keys($this->listaDeTarefas);
			foreach ($keys as $key) {
				if ($this->listaDeTarefas[$key]->getId() == $id) {
					return $key;
				}
			}
			return false;
		}

		public function pegaTarefaPorId($id) {
			$indice = $this->retornaIndiceUsandoId($id);
			$tarefaInfo = array(
				'id' => $id,
				'nome' => $this->listaDeTarefas[$indice]->getNome(),
				'estado' => $this->listaDeTarefas[$indice]->getEstadoString(),
				'tempoEmAtividade' => $this->listaDeTarefas[$indice]->arrayTempoEmAtividade()
				);
			return $tarefaInfo;
		}

		public function adicionaTarefa($nome) {
			$tarefa = new Tarefa($nome);
			$this->listaDeTarefas[] = $tarefa;
			return $tarefa->getId();
		}

		public function removeTarefa($id) {
			$keys = array_keys($this->listaDeTarefas);
			foreach ($keys as $key) {
				if ($this->listaDeTarefas[$key]->getId() == $id) {
					unset($this->listaDeTarefas[$key]);
				}
			}
		}

		public function mudaNomeTarefa($id, $nome) {
			$indice = $this->retornaIndiceUsandoId($id);
			$this->listaDeTarefas[$indice]->setNome($nome);
		}

		public function desativaTodasAsTarefas() {
			foreach ($this->listaDeTarefas as $tarefa) {
				$tarefa->desativa();
			}
		}

		public function ativaTarefa($id) {
			$this->desativaTodasAsTarefas();
			$indice = $this->retornaIndiceUsandoId($id);
			$this->listaDeTarefas[$indice]->ativa();
		}

		public function desativaTarefa($id) {
			$indice = $this->retornaIndiceUsandoId($id);
			$this->listaDeTarefas[$indice]->desativa();
		}

		public function tamanhoListaTarefas() {
			return count($this->listaDeTarefas);
		}

		public function retornaTodosIds() {
			$listaIds = array();
			foreach ( $this->listaDeTarefas as $tarefa ) {
				array_push($listaIds, $tarefa->getId());
			}
			return $listaIds;
		}

		public function listaTarefas() {
			$string = '';
			foreach ($this->listaDeTarefas as $tarefa) {
				$string .= $tarefa->getId() . ' ' . $tarefa->getNome() . '<br/>';
				$string .= $tarefa->toStringDiff($tarefa->tempoEmAtividade()) . '<br/>';
			}
			return $string;
		}

		public function salvaGerenciador() {
			$gerenciadorSerializado = serialize($this);
			$caminhoArquivo = getcwd() . '/salvo/salvo.txt';
			if (is_writable($caminhoArquivo)) {
			    $fp = fopen($caminhoArquivo, "w"); 
			    fwrite($fp, $gerenciadorSerializado); 
			    fclose($fp);
			} else if (!file_exists($caminhoArquivo)) {
				$fp = fopen($caminhoArquivo, "w");
				fwrite($fp, $gerenciadorSerializado); 
				fclose($fp);
			} else {
				return 'Nao escreveu em ' . $caminhoArquivo;
			}
		}
	}

 ?>