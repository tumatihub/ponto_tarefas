<!DOCTYPE html>
<html>
<head>
	<title>Ponto de Tarefas</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
</head>
<body>

<?php

session_start();

if (!isset($_SESSION['usuario'])) {
	header('Location: login.php');
}

?>
<section class="tarefas-container">
	<div id="menu">
		<input id="adiciona" type="text" placeholder="Clique para inserir uma tarefa">
		<a class="btn" href="logout.php">Logout</a>
		<a id="relatorio-button" class="btn" href="#">Relatorio</a>
	</div>
</section>

<section class="relatorio">

</section>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
