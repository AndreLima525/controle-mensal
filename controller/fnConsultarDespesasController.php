<?php

require_once('../model/conn.php');
include_once('../model/fnGetDespesasModel.php');

$usuarioLogin = $_SESSION['idUsuario'] ?? null;

$DT_ConsultaI = null;
$DT_ConsultaT = null;
$prioridade   = null;
$categoria    = null;

// Se clicou em pesquisar
if (isset($_POST['pesquisar'])) {

    $DT_ConsultaI = $_POST['DT_ConsultaI'] ?? null;
    $DT_ConsultaT = $_POST['DT_ConsultaT'] ?? null;
    $prioridade   = $_POST['idPrioridade'] ?? null;
    $categoria    = $_POST['idCategoria'] ?? null;
}

// Sempre executa a busca
$dadosDespesas = getDespesasFiltradas(
    $usuarioLogin,
    $DT_ConsultaI,
    $DT_ConsultaT,
    $prioridade,
    $categoria
);

?>