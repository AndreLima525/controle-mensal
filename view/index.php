<?php
	require_once('../controller/fnLoginController.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Página Inicial</title>
	<link rel="stylesheet" type="text/css" href="../styles/styleIndex.css">
</head>
<body>
	<div class="container"> 
		
			<div class="card">

				<h1>Controle de Gastos</h1>

				<form method="POST">
						<label> Usuário </label>
						<input type="text" name="usuario" required>

						<label> Senho </label>
						<input type="password" name="senha" required>

						<button> Entrar </button>

						<hr>
						<a href="" class="forgot"> Esqueceu sua senha? </a>
					</form>

				</div>

			
		</body>
		</html>