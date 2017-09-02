<?php

require_once '../Tarefa.php';

class testeTarefa extends PHPUnit_Framework_TestCase
{
    private $tarefa;
    private $dataCriacao;

    public function setUP()
    {
        $this->dataCriacao = new DateTime('NOW');
        $this->tarefa = new Tarefa('nome', $this->dataCriacao);
    }

    public function testNomeTarefaInicial()
    {
        $this->assertEquals('nome', $this->tarefa->getNome());
    }

    public function testMudaNomeTarefa()
    {
        $this->tarefa->setNome('outronome');
        $this->assertEquals('outronome', $this->tarefa->getNome());
    }

    public function testEstadoInicialDesativado()
    {
        $this->assertEquals('desativada', $this->tarefa->getEstadoString());
    }

    public function testMudaEstadoInicialDesativadoParaAtivado()
    {
        $this->tarefa->ativa();
        $this->assertEquals('ativada', $this->tarefa->getEstadoString());
    }

    public function testMudaAtivadoParaDesativado()
    {
        $this->tarefa->ativa();
        $this->tarefa->desativa();
        $this->assertEquals('desativada', $this->tarefa->getEstadoString());
    }

    public function testDataDeCriacao()
    {
        $this->assertEquals($this->dataCriacao, $this->tarefa->getDataCriacao());
    }
}
