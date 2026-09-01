<?php
	
require_once('../controller/sair.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Redefinir Senha</title>
	<link rel="stylesheet" type="text/css" href="../styles/styleIndex.css">
	<link rel="icon" type="image/jpeg" href="../images/logoAtomtech.jpeg">
</head>
<body>
	<div class="container"> 
		
		<div class="card">

			<h1>Redefinir a Senha</h1>

			<form method="POST">
				<label> Digite Seu E-mail </label>
				<input type="email" name="usuario" required>

				<button> Solicitar Código </button>

			</form>

		</div>


	</body>
	</html>