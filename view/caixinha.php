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
			<input type="date" name="data" required value="<?= $dataAtual ?>">
		</div>

		<div class="form-group">
			<label>Valor - R$</label>
			<input type="text" name="valorDeposito" placeholder="0,00" required>
		</div>

		<div class="form-group">

			<label>Chave Pix</label>

			<div class="input-wrapper">
				<input type="text" id="chavePix" disabled
				value="<?php if (isset($dsPix)) { echo $dsPix; } else { echo '** Chave não Cadastrada **'; } ?>">

				<input type="hidden" name="idPix" value="<?php if (isset($idPix)) { echo $idPix; } ?>">

				<button type="button" class="btn-copy" title="Copiar" onclick="copiarTexto()">
					<i class="fa-regular fa-copy"></i>
				</button>
			</div>

		</div>

		<div class="form-group">
			<label>Valor Guardado</label>
			<input type="text" name="" disabled value="<?php echo "R$ " . number_format($totalCaixinha, 2, ',', '.');?>">
		</div>

		<div class="form-group full-width">
			<label>Descrição</label>
			<textarea name="dsDeposito" rows="4" placeholder="Digite a descrição..." required></textarea>
		</div>

		<div class="form-actions center">
			<a href="../view/dashboard.php" class="btn btn-voltar" name="voltar">
				<i class="fa-solid fa-arrow-left"></i> Cancelar
			</a>

			<button type="submit" class="btn btn-primary" name="novo">
				<i class="fa-solid fa-wallet"></i> Incluir Depósito
			</button>
		</div>

	</form>

</div>

<script>
	function copiarTexto() {

		const input = document.getElementById('chavePix');
		const botao = document.querySelector('.btn-copy');
		const texto = input.value;

		if (navigator.clipboard && window.isSecureContext) {

			navigator.clipboard.writeText(texto).then(() => {
				animarBotao(botao);
			}).catch(() => {
				copiarFallback(texto, botao);
			});

		} else {
			copiarFallback(texto, botao);
		}
	}

	function copiarFallback(texto, botao) {

		const inputTemp = document.createElement("input");
		inputTemp.value = texto;
		document.body.appendChild(inputTemp);

		inputTemp.select();
		document.execCommand("copy");

		document.body.removeChild(inputTemp);

		animarBotao(botao);
	}

	function animarBotao(botao){

		botao.innerHTML = '<i class="fa-solid fa-check"></i>';
		botao.style.background = '#16a34a';

		setTimeout(() => {
			botao.innerHTML = '<i class="fa-regular fa-copy"></i>';
			botao.style.background = '#2563eb';
		}, 4000);

	}
</script>

