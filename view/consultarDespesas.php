<?php
include_once('../model/fnGetAux.php');
include_once('../controller/fnConsultarDespesasController.php');
?>

<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
    <h2>
        Consultar Despesas
    </h2>
</div>


<div class="card">

	
    <form class="form-grid" method="POST">

        <div class="form-group">
            <label>Data Início</label>
            <input type="date" name="DT_ConsultaI">
        </div>

        <div class="form-group">
            <label>Data Término</label>
            <input type="date" name="DT_ConsultaT">
        </div>

        <div class="form-group">
            <label>Categoria</label>
            
            <select name="categoria">
                <option value="" disabled selected> -- Selecione -- </option>

                <?php foreach ($dadosCategorias as $dados): ?>
                    <option value="<?= $dados['idCategoria']; ?>">
                        <?= $dados['dsCategoria']; ?>
                    </option>
                <?php endforeach; ?>

            </select>
            
        </div>

        <div class="form-group">
            <label>Prioridade</label>

            <select name="prioridade">
                <option value="" disabled selected> -- Selecione -- </option>

                <?php foreach ($dadosPrioridades as $dados): ?>
                    <option value="<?= $dados['idPrioridade']; ?>">
                        <?= $dados['dsPrioridade']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-secondary" name="pesquisar">
                <i class="fa-solid fa-magnifying-glass"></i> Pesquisar
            </button>
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

<div class="paginacao">
    <button id="prev"><i class="fa-solid fa-angle-left"></i></button>
    <span id="paginaAtual"></span>
    <button id="next"><i class="fa-solid fa-angle-right"></i></button>
</div>
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