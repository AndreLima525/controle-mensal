<?php

require_once('../controller/fnConfigSenhaController.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Configurar Senha</title>
	<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
</head>
<body bgcolor="#0f172a">

	<form method="POST">
		<div class="card-senha">
			
			<div class="modal-content-senha">
				<center>
					<h2> Atualizar Senha </h2>
				</center>
				<div class="form-group-senha">
					
					<label>Nova Senha </label>
					<input type="password" name="novaSenha">

				</div> <br>
				
				<div class="form-group-senha">
					<label> Confirmar Nova Senha </label>
					<input type="password" name="novaSenhaConfirm">
				</div> <br>
				
				<center>
					<button class="btn-senha" name="atualizarSenha">
						Atualizar Senha
					</button>

				</center>
				
			</div>

		</div>
	</form>
	
	
</body>
</html>