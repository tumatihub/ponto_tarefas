<!DOCTYPE html>
<html>
<head>
	<title>Ponto de Tarefas</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

<?php

session_start();

if (!isset($_SESSION['usuario'])) {
	header('Location: login.php');
}

?>

<input id="adiciona" type="text" placeholder="Nome da tarefa">
<a href="logout.php">Logout</a>
<a id="relatorio-button" href="#">Relatorio</a>

<section class="relatorio">

</section>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
