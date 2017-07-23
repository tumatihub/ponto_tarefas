<?php
require_once 'GerenciadorDeTarefas.php';

class APITarefas {

	private $gerenciador;

	public function __construct(GerenciadorDeTarefas $gerenciador) {
		$this->gerenciador = $gerenciador;
	}

	public function adicionaTarefa($nome) {
		$id = $this->gerenciador->adicionaTarefa($nome);
		return json_encode(array("id" => $id));
	}

	public function removeTarefa($id) {
		$this->gerenciador->removeTarefa($id);
	}

	public function pegaTodasAsTarefas() {
		$listaDeTarefas = array();
		$listaIds = $this->gerenciador->retornaTodosIds();
		foreach ($listaIds as $id) {
			array_push($listaDeTarefas, $this->gerenciador->pegaTarefaPorId($id));
		}
		return json_encode($listaDeTarefas);
	}

	public function mudaNomeTarefa($id, $nome) {
		$this->gerenciador->mudaNomeTarefa($id, $nome);
	}

	public function desativaTarefa($id) {
		$this->gerenciador->desativaTarefa($id);
		return json_encode($this->gerenciador->pegaTarefaPorId($id));
	}

	public function ativaTarefa($id) {
		$this->gerenciador->ativaTarefa($id);
	}

	public function salvaGerenciador() {
		return $this->gerenciador->salvaGerenciador();
	}

	public function geraRelatorio() {
		$listaRelatorio = $this->gerenciador->geraRelatorio();
		return json_encode($listaRelatorio);
	}
}

?>
