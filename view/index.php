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
	<link rel="icon" type="image/jpeg" href="../images/logoAtomtech.jpeg">
	<link rel="manifest" href="../manifest.json">
	<meta name="theme-color" content="#0d6efd">
	<link rel="apple-touch-icon" href="/projetoControle/icons/ios-192.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<meta name="mobile-web-app-capable" content="yes">
</head>
<body>
	<div class="container"> 
		
		<div class="card">

			<div class="logo">
				<center>
					<img src="../images/logoAtomtech.jpeg" width="120px">
				</center> 
			</div>

			<h1>Controle de Gastos</h1>

			<form method="POST">
				<label> Usuário </label>
				<input type="text" name="usuario" required>

				<label> Senha </label>
				<input type="password" name="senha" required>

				<button type="submit"> Entrar </button>

				<hr>
				<!-- <a href="esqueceuSenha.php" class="forgot"> Esqueceu sua senha? </a> -->
				<button id="btnInstalar" style="display:none;">
					📲 Instalar aplicativo
				</button>
			</form>

		</div>

		

		<script>

			let deferredPrompt;
			const btnInstalar = document.getElementById("btnInstalar");

			/* Detecta se pode instalar */
			window.addEventListener("beforeinstallprompt", (e) => {

				e.preventDefault();

				if (window.matchMedia('(display-mode: standalone)').matches) {
					return;
				}

				deferredPrompt = e;
				btnInstalar.style.display = "block";

			});

			/* Clique no botão */
			btnInstalar.addEventListener("click", async () => {

				if (!deferredPrompt) return;

				deferredPrompt.prompt();

				const { outcome } = await deferredPrompt.userChoice;

				if (outcome === "accepted") {
					console.log("Usuário instalou o app");
				}

				deferredPrompt = null;
				btnInstalar.style.display = "none";

			});

			/* Quando instalar */
			window.addEventListener("appinstalled", () => {
				btnInstalar.style.display = "none";
			});

		</script>

		<script>
			if ('serviceWorker' in navigator) {

				window.addEventListener('load', () => {

					navigator.serviceWorker.register('/projetoControle/service-worker.js')
					.then(registration => {
						console.log('Service Worker registrado:', registration.scope);

						registration.update();
					})
					.catch(error => {
						console.error('Erro ao registrar Service Worker:', error);
					});

				});

			}
		</script>
	</body>
	</html>