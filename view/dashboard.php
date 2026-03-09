<?php
include_once('../controller/sair.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../styles/styleDashboard.css">
	<link rel="icon" type="image/jpeg" href="../images/logoAtomtech.jpeg">
</head>
<body>

	<!-- BOTÃO MOBILE -->
	<div class="mobile-toggle" onclick="toggleSidebar()">
		<i class="fa-solid fa-bars"></i>
	</div>

	<div class="sidebar">
		<div class="logo">
			<i class="fa-solid fa-chart-line"></i>
			<span>Controle Financeiro</span>
		</div>

		<ul class="menu">

			<li class="menu-usuario">
				<i class="fa-solid fa-circle-user"></i>
				<span><?php echo $_SESSION['usuario']; ?></span> 

					<a href="?pagina=alterSenhaPix" class="btnAlterarSenha" title="Alterar Senha / Pix"> <i class="fa fa-key"></i> </a>
				
			</li>
			
			<li>
				<a href="?pagina=home">
					<i class="fa-solid fa-gauge"></i>
					<span>Dashboard</span>
				</a>
			</li>

			<li>
				<a href="?pagina=incluir">
					<i class="fa-solid fa-plus-circle"></i>
					<span>Incluir Despesas</span>
				</a>
			</li>

			<li>
				<a href="?pagina=consultar">
					<i class="fa-solid fa-magnifying-glass-dollar"></i>
					<span>Consultar Despesas</span>
				</a>
			</li>

			<li>
				<a href="?pagina=caixinha">
					<i class="fa-solid fa-wallet"></i>
					<span>Carteira</span>
				</a>
			</li>

			<li>
				<a href="?pagina=relatorios">
					<i class="fa-solid fa-chart-pie"></i>
					<span>Relatórios</span>
				</a>
			</li>

			<?php if ($_SESSION['acesso'] == 1):?>
				<li>

					<a href="?pagina=config">
						<i class="fa-solid fa-gear"></i>
						<span>Configurações</span>
					</a>
				</li>
			<?php endif;?>
			<hr class="divider">
			<li class="logout-item">
				<a href="../controller/sair.php?sair">
					<i class="fa-solid fa-right-from-bracket"></i>
					<span>Sair</span>
				</a>
			</li>
		</ul>
	</div>


	<div class="main-content">
		<div class="dashboard">

			
			

			<?php
			$pagina = $_GET['pagina'] ?? 'home';

			switch($pagina){

				case 'incluir':
				include 'incluir.php';
				break;

				case 'consultar':
				include 'consultarDespesas.php';
				break;

				case 'caixinha':
				include 'caixinha.php';
				break;

				case 'relatorios':
				include 'relatorios.php';
				break;

				case 'config':
				include 'config.php';
				break;

				case 'alterSenhaPix':
				include 'alterSenhaPix.php';
				break;

				default:
				include 'home.php';
				break;

				
			}
			?>

			
		</div>

	</div>

</body>
</html>


<script>

	function toggleSidebar() {
		const sidebar = document.querySelector('.sidebar');
		const main = document.querySelector('.main-content');
		sidebar.classList.toggle('active');
		main.classList.toggle('shifted'); 
	}
</script>