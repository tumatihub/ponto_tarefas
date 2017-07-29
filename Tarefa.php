<?php
	class Tarefa {

		private $id;
		private $nomeTarefa;
		private $dataCriacao;
		private $tempoTotal;
		private $dataAtivada;
		private $dataDesativada;
		private $dataReferenciaInicial;
		private $dataReferenciaFinal;
		private $estado;

		public function __construct($nome){
			$this->id = md5($nome . date('NOW') . rand());
			$this->nomeTarefa = $nome;
			$this->dataCriacao = new DateTime('NOW');
			$this->dataReferenciaInicial = new DateTime('NOW');
			$this->dataReferenciaFinal = new DateTime('NOW');
			$this->estado = new TarefaDesativada;
		}

		public function getNome(){
			return $this->nomeTarefa;
		}

		public function setNome($nome){
			$this->nomeTarefa = $nome;
		}

		public function getId(){
			return $this->id;
		}

		public function setEstado(EstadoDeTarefa $estado){
			$this->estado = $estado;
		}

		public function getEstado(){
			return $this->estado;
		}

		public function getEstadoString() {
			return $this->estado->getEstadoString();
		}

		public function atualizaDataAtivada() {
			$this->dataAtivada = new DateTime('NOW');
		}

		public function atualizaDataDesativada() {
			$this->dataDesativada = new DateTime('NOW');
			$this->dataReferenciaFinal->add($this->dataAtivada->diff($this->dataDesativada));
		}

		public function ativa(){
			$this->estado->ativa($this);
		}

		public function desativa(){
			$this->estado->desativa($this);
		}

		public function tempoEmAtividade(){
			return $this->dataReferenciaInicial->diff($this->dataReferenciaFinal);
		}

		public function arrayTempoEmAtividade(){
			$diff = $this->tempoEmAtividade();
			$partes = array('y', 'm', 'd', 'h', 'i', 's');
			$arrayDiff = array();
			foreach($partes as $parte) {
				$arrayDiff[$parte] = sprintf("%'.02d", $diff->$parte);
			}
			return $arrayDiff;
		}

		public function toStringDiff(DateInterval $diff){
			$unidades = array('a' => 'y', 'm' => 'm', 'd' => 'd', 'h' => 'h', 'min' => 'i', 's' => 's');
			$partes = array_values($unidades);
			$string = '';
			foreach($partes as $parte){
				if ( $parte == 's' || $diff->$parte > 0 ){
					$unidade = array_search($parte, $unidades);
					$string = $string . ' ' . sprintf("%'.02d", $diff->$parte) . "${unidade}";
				}
			}
			return $string;
		}

		public function getTempoFloat(){
			$arrayDiff = $this->arrayTempoEmAtividade();
			$horas = $arrayDiff['h'];
			$minutos = $arrayDiff['i']/60;
			return $horas + $minutos;
		}
	}
 ?>
