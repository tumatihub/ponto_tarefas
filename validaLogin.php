<?php 

session_start();

$_SESSION['usuario'] = true;

header('Location: carregaUsuario.php');

?>