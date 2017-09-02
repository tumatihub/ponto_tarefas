<?php 

require_once 'GerenciadorDeTarefas.php';
date_default_timezone_set('Brazil/East');
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
}

if (!isset($_SESSION['gerenciador'])) {
    $caminhoArquivo = getcwd() . '/salvo/salvo.txt';
    if (file_exists($caminhoArquivo)) {
        $conteudoArquivo = file_get_contents($caminhoArquivo);
        $_SESSION['gerenciador'] = unserialize($conteudoArquivo);
    } else {
        $_SESSION['gerenciador'] = new GerenciadorDeTarefas();
    }
}

header('Location: index.php');
