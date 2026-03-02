<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
    <h2>
        Consultar Despesas
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
            <tr>
                <td class="data">02/03/2026</td>
                <td class="categoria">Alimentação</td>
                <td class="descricao">Mercado</td>
                <td class="valor">150,00</td>
                <td class="acoes">
                    <button class="btn-editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn-excluir">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>