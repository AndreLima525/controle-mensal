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
			<h3>Total na Carteira</h3>
			<p><?php echo "R$ " . number_format($totalCaixinha, 2, ',', '.');?></p>
		</div>
	</div>

</div>

<!-- ÚLTIMAS DESPESAS -->
<div class="card-lista">
	<h3>Últimas Despesas</h3>

	<table class="tabela-financeiro">
		<thead>
			<tr>
				<th>Data</th>
				<th>Categoria</th>
				<th>Descrição</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($despesasDash)): ?>
				<?php foreach($despesasDash as $dados):?>
					<tr>
						<td><?= date('d-m-Y', strtotime($dados['dataDespesa'])); ?></td>
						<td><?= $dados['dsCategoria']; ?></td>
						<td><?= $dados['dsDespesa']; ?></td>
						<td>R$ <?= number_format($dados['valorDespesa'], 2, ',', '.'); ?></td>
					</tr>
				<?php endforeach;?>
			<?php else: ?>
			<tr>
				<td colspan="5">Nenhuma despesa encontrada.</td>
			</tr>
			<?php endif; ?>
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