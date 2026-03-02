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

            <button type="submit" class="btn btn-primary" name="novo">
                <i class="fa-solid fa-plus-circle"></i> Novo
            </button>
        </div>

    </form>

</div>

<div class="card-lista">

</div>