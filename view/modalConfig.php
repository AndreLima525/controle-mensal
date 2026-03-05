<?php
include_once('../model/fnGetAux.php');
include_once('../controller/fnConfigController.php');
?>

<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
	<h2>
		Configurações
	</h2>
</div>


<div class="card">

	
	<form class="form-grid" method="POST">

		<div class="form-group">
			<label>Nome</label>
			<input type="text" name="nome">
		</div>



		<div class="form-group">
			<label>Status</label>

			<select name="stAtivo">
				<option value="" disabled selected> -- Selecione -- </option>
				<option value="1"> Ativo </option>
				<option value="0"> Inativo </option>

			</select>

		</div>

		<div class="form-group">
			<div class="form-actions">
				<button type="submit" class="btn btn-secondary" name="pesquisar">
					<i class="fa-solid fa-magnifying-glass"></i> Pesquisar
				</button>
				
				<button type="submit" class="btn btn-primary" name="novo">
					<i class="fa-solid fa-plus-circle"></i> Novo Usuário
				</button>
			</div>
		</div>




	</form>

</div>

<div class="card-lista">
	<table class="tabela-financeiro">
		<thead>
			<tr>
				<th>Data</th>
				<th>Categoria</th>
				<th>Descrição</th>
				<th>Valor - R$</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>

			<?php if (is_array($dadosDespesas) && count($dadosDespesas) > 0): ?>

			<?php foreach($dadosDespesas as $dadoDespesa): ?>
				<tr>
					<td class="data"><?= date('d-m-Y', strtotime($dadoDespesa['dataDespesa'])); ?></td>
					<td class="categoria"><?= $dadoDespesa['dsCategoria']; ?></td>
					<td class="descricao"><?= $dadoDespesa['dsDespesa']; ?></td>
					<td class="valor">R$ <?= number_format($dadoDespesa['valorDespesa'], 2, ',', '.'); ?></td>
					<td class="acoes">

						<button class="btn-editar" 
						data-id="<?= $dadoDespesa['idDespesa']; ?>"
						data-descricao="<?= $dadoDespesa['dsDespesa']; ?>"
						data-valor="<?= number_format($dadoDespesa['valorDespesa'], 2, ',', '.'); ?>"
						data-data="<?= $dadoDespesa['dataDespesa']; ?>">

						<i class="fa-solid fa-pen-to-square"></i>
					</button>

					<a href="../model/deleteDespesaModel.php?id=<?= $dadoDespesa['idDespesa']; ?>" 
						class="btn-excluir"
						onclick="return confirm('Deseja realmente excluir esta despesa?');">
						<i class="fa-solid fa-trash-can"></i>
					</a>

				</td>
			</tr>
		<?php endforeach; ?>

	<?php else: ?>
		<tr>
			<td colspan="5">Nenhuma despesa encontrada.</td>
		</tr>
	<?php endif; ?>
</tbody>
</table>
</div>

<div id="modalEditar" class="modal">
	<div class="modal-content">
		<h3>Editar Despesa</h3>

		<form action="../model/updateDespesa.php" method="POST">
			<input type="hidden" name="id" id="edit-id">

			<div class="form-group">
				<label>Descrição</label>
				<input type="text" name="descricao" id="edit-descricao">
			</div>

			<div class="form-group">
				<label>Valor</label>
				<input type="text" name="valor" id="edit-valor">
			</div>

			<div class="form-group">
				<label>Data</label>
				<input type="date" name="data" id="edit-data">
			</div>

			<div class="form-actions center">
				<button type="button" onclick="fecharModal()" class="btn btn-secondary">Cancelar</button>
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
		</form>
	</div>
</div>

<script>
	const modal = document.getElementById("modalEditar");

	document.querySelectorAll(".btn-editar").forEach(btn => {
		btn.addEventListener("click", function() {

			document.getElementById("edit-id").value = this.dataset.id;
			document.getElementById("edit-descricao").value = this.dataset.descricao;
			document.getElementById("edit-valor").value = this.dataset.valor;
			document.getElementById("edit-data").value = this.dataset.data;

			modal.style.display = "flex";
		});
	});

	function fecharModal() {
		modal.style.display = "none";
	}

	window.onclick = function(e) {
		if (e.target === modal) {
			fecharModal();
		}
	}
</script>