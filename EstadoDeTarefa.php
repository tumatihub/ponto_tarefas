<?php 
    require_once 'Tarefa.php';

    interface EstadoDeTarefa
    {
        public function ativa(Tarefa $tarefa);
        public function desativa(Tarefa $tarefa);
        public function getEstadoString();
    }
