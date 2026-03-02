<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
	<h2>
		Incluir Nova Despesa
	</h2>
</div>

<div class="card">

	
	<form class="form-grid" method="POST">

		<div class="form-group">
			<label>Data</label>
			<input type="date" name="data">
		</div>

		<div class="form-group">
			<label>Categoria</label>
			<select name="categoria">
				<option disabled selected> -- Selecione -- </option>
			</select>
		</div>

		<div class="form-group">
			<label>Prioridade</label>
			<select name="prioridade">
				<option disabled selected> -- Selecione -- </option>
			</select>
		</div>

		<div class="form-group">
			<label>Valor - R$</label>
			<input type="number" name="valorDespesa">
		</div>

	</form>

	<div class="form-group full-width">
		<label>Descrição</label>
		<textarea name="dsDespesa" rows="4" placeholder="Digite a descrição da despesa..."></textarea>
	</div>

	<div class="form-actions center">

		<button type="submit" class="btn btn-voltar" name="voltar">
			<i class="fa-solid fa-arrow-left"></i> Cancelar
		</button>
		<button type="submit" class="btn btn-primary" name="novo">
			<i class="fa-solid fa-plus-circle"></i> Incluir Despesa
		</button>
	</div>

</div>


