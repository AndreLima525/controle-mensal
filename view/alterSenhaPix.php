<?php

include_once('../model/fnGetAux.php');
include_once('../controller/fnAlterarSenhaPixController.php');
require_once('../controller/sair.php');
?>

<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
	<h2>
		Alterar Senha / Dados Pix
	</h2>
</div>

<div class="card">
	<form class="form-grid" method="POST">
		<div class="form-group">
			<label>Nova Senha </label>
			<input type="password" name="novaSenha">
		</div>
		<div class="form-group">
			<label>Confirme a nova Senha </label>
			<input type="password" name="novaSenhaConfirm">
		</div>
		<div class="form-group">
			<label>Banco Pix </label>
			<input type="text" id="edit-bpix" name="dsBancoPix"
			value="<?php if (!empty($dsBancoPix)) { echo $dsBancoPix; } ?>">
		</div>
		<div class="form-group">
			<label>Chave Pix </label>
			<input type="text" id="edit-pix" name="dsPix"
			value="<?php if (!empty($dsPix)) { echo $dsPix; } ?>">

			<input type="hidden" name="idPix" value="<?php if (isset($idPix)) { echo $idPix; } ?>">
		</div>

		<div class="form-actions center">
			<a href="../view/dashboard.php" class="btn btn-voltar" name="voltar">
				<i class="fa-solid fa-arrow-left"></i> Cancelar
			</a>

			<button type="submit" class="btn btn-primary" name="alterar">
				<i class="fas fa-save"></i> Alterar Dados
			</button>
		</div>
	</form>
</div>