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
			<li>
				<a href="incluir-despesa.php">
					<i class="fa-solid fa-plus-circle"></i>
					<span>Incluir Despesas</span>
				</a>
			</li>
			<li>
				<a href="consultar-despesas.php">
					<i class="fa-solid fa-magnifying-glass-dollar"></i>
					<span>Consultar Despesas</span>
				</a>
			</li>
			<li>
				<a href="cofrinho.php">
					<i class="fa-solid fa-wallet"></i>
					<span>Caixinha</span>
				</a>
			</li>
			<li>
				<a href="relatorios.php">
					<i class="fa-solid fa-chart-pie"></i>
					<span>Relatórios</span>
				</a>
			</li>
			<li>
				<a href="configuracoes.php">
					<i class="fa-solid fa-gear"></i>
					<span>Configurações</span>
				</a>
			</li>
			<hr class="divider">
			<li class="logout-item">
				<a href="../controller/sair.php">
					<i class="fa-solid fa-right-from-bracket"></i>
					<span>Sair</span>
				</a>
			</li>
		</ul>
	</div>


	<div class="main-content">



		<div class="dashboard">

			<!-- CARDS RESUMO -->
			<div class="cards-resumo">

				<div class="card resumo">
					<div class="card-icon blue">
						<i class="fa-solid fa-calendar-day"></i>
					</div>
					<div class="card-info">
						<h3>Despesas do Mês</h3>
						<p>R$ 2.350,00</p>
					</div>
				</div>

				<div class="card resumo">
					<div class="card-icon green">
						<i class="fa-solid fa-wallet"></i>
					</div>
					<div class="card-info">
						<h3>Total na Caixinha</h3>
						<p>R$ 5.800,00</p>
					</div>
				</div>

			</div>


			<!-- ÚLTIMAS DESPESAS -->
			<div class="card lista-despesas">
				<h3>Últimas Despesas</h3>

				<table>
					<thead>
						<tr>
							<th>Descrição</th>
							<th>Categoria</th>
							<th>Valor</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Supermercado</td>
							<td>Alimentação</td>
							<td>R$ 350,00</td>
							<td>18/02/2026</td>
						</tr>
						<tr>
							<td>Internet</td>
							<td>Casa</td>
							<td>R$ 120,00</td>
							<td>15/02/2026</td>
						</tr>
					</tbody>
				</table>
			</div>


			<!-- POWER BI -->
			<div class="card powerbi">
				<h3>Evolução Anual</h3>

				<iframe 
				title="Power BI"
				width="100%" 
				height="400" 
				src="LINK_DO_SEU_POWERBI_AQUI"
				frameborder="0"
				allowFullScreen="true">
			</iframe>
		</div>

	</div>
</div>
</body>
</html>

<script>
	function toggleSidebar() {
		const sidebar = document.querySelector('.sidebar');
		const main = document.querySelector('.main-content');
		sidebar.classList.toggle('active');
    main.classList.toggle('shifted'); // importante para empurrar o conteúdo
}
</script>