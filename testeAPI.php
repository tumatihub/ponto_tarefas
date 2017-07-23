<?php 
require_once 'GerenciadorDeTarefas.php';
require_once 'APITarefas.php';

$gerenciador = new GerenciadorDeTarefas();
$api = new APITarefas($gerenciador);

var_dump($gerenciador);
var_dump($api);

$json = $api->adicionaTarefa('nome');

var_dump($json);
 ?>