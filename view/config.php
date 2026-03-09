<?php
include_once('../model/fnGetAux.php');
include_once('../controller/fnConfigController.php');
include_once('../controller/protectedConfig.php');
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

				<button type="button" class="btn btn-primary" onclick="abrirModalNovo()">
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
				<th>Nome Do Usuário</th>
				<th>Nível de Acesso</th>
				<th>Status</th>
				<th>Ações</th> 
			</tr>
		</thead>
		<tbody>

			<?php if (is_array($dadosUsuarios) && count($dadosUsuarios) > 0): ?>

			<?php foreach($dadosUsuarios as $dadoUsuario): ?>
				<tr>
					
					<td class="descricao"><?= $dadoUsuario['nomeUsuario']; ?></td>
					<td class="descricao"><?= $dadoUsuario['dsAcesso']; ?></td>
					<td class="descricao"><?php  if($dadoUsuario['stAtivo'] == 1) { echo "Ativo"; } else {echo "Inativo";} ?></td>

					<td class="acoes">

						<button class="btn-editar"
						data-id="<?= $dadoUsuario['idUsuario']; ?>"
						data-descricao="<?= $dadoUsuario['nomeUsuario']; ?>"
						data-email="<?= $dadoUsuario['email']; ?>"
						data-nivel-acesso="<?= $dadoUsuario['idNivelAcesso']; ?>"
						data-stativo="<?= $dadoUsuario['stAtivo']; ?>"
						data-bPix="<?= $dadoUsuario['dsBancoPix']; ?>"
						data-pix="<?= $dadoUsuario['dsPix']; ?>"
						data-idpix="<?= $dadoUsuario['idPix']; ?>">
						


						<i class="fa-solid fa-pen-to-square"></i>
					</button>

					<?php if ($dadoUsuario['stAtivo'] == 1): ?>


						<a href="../model/deleteUsuarioModel.php?id=<?= $dadoUsuario['idUsuario']; ?>" 
							class="btn-excluir"
							onclick="return confirm('Deseja desativar o usuário?');">
							<i class="fa-solid fa-trash-can"></i>
						</a>

					<?php endif ?>

				</td>
			</tr>
		<?php endforeach; ?>

	<?php else: ?>
		<tr>
			<td colspan="5">Nenhum usuário encontrado.</td>
		</tr>
	<?php endif; ?>
</tbody>
</table>
	<div class="paginacao">
		<button id="prev"><i class="fa-solid fa-angle-left"></i></button>
		<span id="paginaAtual"></span>
		<button id="next"><i class="fa-solid fa-angle-right"></i></button>
	</div>
</div>

<div id="modalNovo" class="modal">
	<div class="modal-content">

		<center>
			<h3>Novo Usuário</h3>
		</center>

		<form method="POST">

			<div class="form-group">
				<label>Nome do Usuário</label>
				<input type="text" name="nomeUsuario" required>
			</div>

			<div class="form-group">
				<label>E-mail</label>
				<input type="email" name="email" required>
			</div>

			<div class="form-group">
				<label>Login</label>
				<input type="text" name="login" required>
			</div>

			<div class="form-group">
				<label>Senha Padrão</label>
				<input type="text" disabled value="Senha@nova">
			</div>

			<div class="form-group">
				<label>Nível de Acesso</label>

				<select name="idNivelAcesso" required>
					<option value=""> -- Selecione -- </option>

					<?php foreach($dadosAcesso as $dado): ?>
						<option value="<?= $dado['idNivelAcesso'] ?>">
							<?= $dado['dsAcesso'] ?>
						</option>
					<?php endforeach; ?>

				</select>
			</div>

			<div class="form-group">
				<label>Banco Pix</label>
				<input type="text" name="dsBancoPix">
			</div>

			<div class="form-group">
				<label>Chave Pix</label>
				<input type="text" name="dsPix">
			</div>

			<div class="form-actions center">
				<button type="button" onclick="fecharModalNovo()" class="btn btn-secondary">
					Cancelar
				</button>

				<button type="submit" class="btn btn-primary" name="novo">
					Cadastrar
				</button>
			</div>

		</form>

	</div>
</div>

<div id="modalEditar" class="modal">
	<div class="modal-content">

		<center>
			<h3>Editar Usuário</h3>
		</center>
		

		<form action="../model/updateUsuario.php" method="POST">
			<input type="hidden" name="id" id="edit-id">

			<div class="form-group">
				<label>Nome do Usuário</label>
				<input type="text" name="descricao" id="edit-descricao">
			</div> <br>

			<div class="form-group">
				<label>E-mail do Usuário</label>
				<input type="email" name="email" id="edit-email">
			</div><br>

			<div class="form-group">
				<label>Nível de Acesso</label>

				<select name="idNivelAcesso" id="edit-nivelAcesso" >
					<option value="" disabled selected> -- Selecione -- </option>
					<?php foreach($dadosAcesso as $dado): ?>
						<option value="<?= $dado['idNivelAcesso'] ?>"> <?= $dado['dsAcesso'] ?></option>
					<?php endforeach; ?>
				</select>

			</div>	<br>	

			<div class="form-group">
				<label>Banco Pix </label>
				<input type="text" id="edit-bpix" name="dsBancoPix"
				value="<?php if (!empty($dsBancoPix)) { echo $dsBancoPix; } ?>">
			</div><br>
			<div class="form-group">
				<label>Chave Pix </label>
				<input type="text" id="edit-pix" name="dsPix"
				value="<?php if (!empty($dsPix)) { echo $dsPix; } ?>">

				<input type="hidden" name="idPix" value="<?php if (isset($idPix)) { echo $idPix; } ?>">
			</div><br>

			<div class="form-actions center">
				<button type="button" onclick="fecharModal()" class="btn btn-secondary">Cancelar</button>

				<button type="submit" class="btn btn-primary" id="btn-acao">Salvar</button>

				
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
			document.getElementById("edit-email").value = this.dataset.email;
			document.getElementById("edit-nivelAcesso").value = this.dataset.nivelAcesso;
			document.getElementById("edit-bpix").value = this.dataset.bpix;
			document.getElementById("edit-pix").value = this.dataset.pix;
			document.querySelector("input[name='idPix']").value = this.dataset.idpix;

			let ativo = this.dataset.stativo;

			let botao = document.getElementById("btn-acao");

			if (ativo == "1") {
				botao.innerText = "Salvar";
			} else {
				botao.innerText = "Reativar Acesso";
			}

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

<script>
	const modalNovo = document.getElementById("modalNovo");

	function abrirModalNovo() {
		modalNovo.style.display = "flex";
	}

	function fecharModalNovo() {
		modalNovo.style.display = "none";
	}

	window.addEventListener("click", function(e) {
		if (e.target === modalNovo) {
			fecharModalNovo();
		}
	});
</script>

<script>

const linhas = document.querySelectorAll(".tabela-financeiro tbody tr");
const linhasPorPagina = 5;

let paginaAtual = 1;

function mostrarPagina(pagina){

    const inicio = (pagina - 1) * linhasPorPagina;
    const fim = inicio + linhasPorPagina;

    linhas.forEach((linha, index) => {
        linha.style.display = (index >= inicio && index < fim) ? "" : "none";
    });

    document.getElementById("paginaAtual").innerText = "Página " + pagina;
}

document.getElementById("next").addEventListener("click", () => {

    if(paginaAtual * linhasPorPagina < linhas.length){
        paginaAtual++;
        mostrarPagina(paginaAtual);
    }

});

document.getElementById("prev").addEventListener("click", () => {

    if(paginaAtual > 1){
        paginaAtual--;
        mostrarPagina(paginaAtual);
    }

});

mostrarPagina(paginaAtual);

</script>