<?php

require_once('../model/conn.php');
include_once('../model/fnGetDespesasModel.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuarioLogin = $_SESSION['idUsuario'] ?? null;
    $DT_ConsultaI = $_POST['DT_ConsultaI'] ?? null;
    $DT_ConsultaT = $_POST['DT_ConsultaT'] ?? null;
    $prioridade   = $_POST['prioridade'] ?? null;
    $categoria    = $_POST['categoria'] ?? null;
    
    $dadosDespesas = getDespesasFiltradas(
        $usuarioLogin,
        $DT_ConsultaI,
        $DT_ConsultaT,
        $prioridade,
        $categoria
    );

} else {

    $usuarioLogin = $_SESSION['idUsuario'] ?? null;

    $dadosDespesas = getDespesas($usuarioLogin);

}




?>