<?php
	include_once('../model/fnGetAux.php');
    require_once('../controller/sair.php');
?>

<link rel="icon" type="image/jpeg" href="../images/logoAtomtech.jpeg">
<link rel="stylesheet" type="text/css" href="../styles/stylePages.css">
<div class="page-header">
	<h2>
		Relatórios
	</h2>
</div>

<div class="card">

	<h3> Despesas </h3>
	<form class="form-grid" method="POST" action="../con
    troller/fnRelatorioDespesas.php" target="_blank">

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
                <option value="">-- TODAS --</option>

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
                <option value="">-- TODAS --</option>

                <?php foreach ($dadosPrioridades as $dados): ?>
                    <option value="<?= $dados['idPrioridade']; ?>">
                        <?= $dados['dsPrioridade']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-secondary" name="relatorioDespesas">
                <i class="fa-solid fa-chart-pie"></i> Gerar Relatório
            </button>
        </div>

    </form>
</div>

<div class="card">

	<h3> Carteira </h3>

	<form class="form-grid" method="POST" action="../controller/fnRelatorioCarteira.php" target="_blank">
		<div class="form-group">
            <label>Data Início</label>
            <input type="date" name="DT_ConsultaI">
        </div>

        <div class="form-group">
            <label>Data Término</label>
            <input type="date" name="DT_ConsultaT">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-secondary" name="relatorioCarteira">
                <i class="fa-solid fa-chart-pie"></i> Gerar Relatório
            </button>
        </div>
        <div class="form-group">
        </div>
	</form>
</div>