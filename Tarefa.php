<?php
require_once 'TarefaDesativada.php';
require_once 'TarefaAtivada.php';

class Tarefa
{
    private $id;
    private $nomeTarefa;
    private $dataCriacao;
    private $tempoTotal;
    private $dataAtivada;
    private $dataDesativada;
    private $dataReferenciaInicial;
    private $dataReferenciaFinal;
    private $estado;
    private $ultimaAtualizacao;

    public function __construct($nome, DateTime $data)
    {
        $this->id = md5($nome . date('NOW') . rand());
        $this->nomeTarefa = $nome;
        $this->dataCriacao = clone $data;
        $this->dataReferenciaInicial = clone $data;
        $this->dataReferenciaFinal = clone $data;
        $this->estado = new TarefaDesativada;
    }

    public function getNome()
    {
        return $this->nomeTarefa;
    }

    public function setNome($nome)
    {
        $this->nomeTarefa = $nome;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    public function setEstado(EstadoDeTarefa $estado)
    {
        $this->estado = $estado;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function isAtiva()
    {
        return $this->estado->isAtiva();
    }

    public function getEstadoString()
    {
        return $this->estado->getEstadoString();
    }

    public function atualizaDataAtivada(DateTime $data)
    {
        $this->dataAtivada = $data;
        $this->ultimaAtualizacao = clone $data;
    }

    public function atualizaDataDesativada(DateTime $data)
    {
        $this->dataDesativada = $data;
        $this->atualizaTempoTarefa($data);
    }

    public function atualizaTempoTarefa(DateTime $data)
    {
        $this->dataReferenciaFinal->add($this->ultimaAtualizacao->diff($data));
        $this->ultimaAtualizacao = $data;
    }

    public function ativa()
    {
        $this->estado->ativa($this);
    }

    public function desativa()
    {
        $this->estado->desativa($this);
    }

    public function tempoEmAtividade()
    {
        return $this->dataReferenciaInicial->diff($this->dataReferenciaFinal);
    }

    public function arrayTempoEmAtividade()
    {
        $diff = $this->tempoEmAtividade();
        $partes = array('y', 'm', 'd', 'h', 'i', 's');
        $arrayDiff = array();
        foreach ($partes as $parte) {
            $arrayDiff[$parte] = sprintf("%'.02d", $diff->$parte);
        }
        return $arrayDiff;
    }

    public function toStringDiff(DateInterval $diff)
    {
        $unidades = array('a' => 'y', 'm' => 'm', 'd' => 'd', 'h' => 'h', 'min' => 'i', 's' => 's');
        $partes = array_values($unidades);
        $string = '';
        foreach ($partes as $parte) {
            if ($parte == 's' || $diff->$parte > 0) {
                $unidade = array_search($parte, $unidades);
                $string = $string . ' ' . sprintf("%'.02d", $diff->$parte) . "${unidade}";
            }
        }
        return $string;
    }

    public function getTempoFloat()
    {
        $arrayDiff = $this->arrayTempoEmAtividade();
        $horas = $arrayDiff['h'];
        $minutos = $arrayDiff['i']/60;
        return $horas + $minutos;
    }
}
