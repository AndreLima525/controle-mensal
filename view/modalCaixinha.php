<?php 

include_once('../model/fnGetAux.php');
include_once('../controller/fnIncluirCaixinhaController.php');

?>


<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
	<h2>
		Incluir Novo Depósito
	</h2>
</div>

<div class="card">

	
	<form class="form-grid" method="POST">

    <div class="form-group">
        <label>Data</label>
        <input type="date" name="data" required>
    </div>

    <div class="form-group">
        <label>Valor - R$</label>
        <input type="text" name="valorDespesa" required>
    </div>

    <div class="form-group">
        <label>Chave Pix</label>
        <input type="text" name="" disabled value="">
    </div>

    <div class="form-group full-width">
        <label>Descrição</label>
        <textarea name="dsDespesa" rows="4" placeholder="Digite a descrição..." required></textarea>
    </div>

    <div class="form-actions center">
        <a href="../view/dashboard.php" class="btn btn-voltar" name="voltar">
            <i class="fa-solid fa-arrow-left"></i> Cancelar
        </a>

        <button type="submit" class="btn btn-primary" name="novo">
            <i class="fa-solid fa-plus-circle"></i> Incluir Despesa
        </button>
    </div>

</form>

</div>