<?php
	
	include_once('../model/fnGetAux.php');

?>

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
			<p><?php echo "R$ " . number_format($totalCaixinha, 2, ',', '.');?></p>
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