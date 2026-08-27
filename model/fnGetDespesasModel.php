<?php

require_once('conn.php');

function getDespesasFiltradas($usuarioLogin, $DT_ConsultaI = null, $DT_ConsultaT = null, $prioridade = null, $categoria = null) {
    global $pdo;

    $sql = "SELECT 
    TD.idDespesa,
    TD.dataDespesa,
    TD.dsDespesa,
    TD.valorDespesa,
    TD.IC_Paga,
    TP.dsPrioridade,
    TC.dsCategoria
    
    FROM despesas TD
    INNER JOIN categorias TC 
    ON TC.idCategoria = TD.idCategoria
    INNER JOIN prioridadesdespesas TP 
    ON TP.idPrioridade = TD.idPrioridade
    WHERE TD.idUsuario = :usuario";

    $params = [':usuario' => $usuarioLogin];

    // FILTRO DATA INICIAL
    if (!empty($DT_ConsultaI)) {
        $sql .= " AND DATE(TD.dataDespesa) >= :dataInicio";
        $params[':dataInicio'] = $DT_ConsultaI;
    }

    // FILTRO DATA FINAL
    if (!empty($DT_ConsultaT)) {
        $sql .= " AND DATE(TD.dataDespesa) <= :dataFinal";
        $params[':dataFinal'] = $DT_ConsultaT;
    }

    // FILTRO PRIORIDADE
    if ($prioridade !== null && $prioridade !== '') {
        $sql .= " AND TD.idPrioridade = :prioridade";
        $params[':prioridade'] = (int)$prioridade;
    }

    // FILTRO CATEGORIA
    if ($categoria !== null && $categoria !== '') {
        $sql .= " AND TD.idCategoria = :categoria";
        $params[':categoria'] = (int)$categoria;
    }

    $sql .= " ORDER BY TD.dataDespesa DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDespesas($usuarioLogin) {

    global $pdo;

    $sql = "SELECT 
    TD.idDespesa,
    TD.dataDespesa,
    TD.dsDespesa,
    TD.valorDespesa,
    TD.IC_Paga,
    TP.dsPrioridade,
    TC.dsCategoria

    FROM despesas TD
    INNER JOIN categorias TC 
    ON TC.idCategoria = TD.idCategoria
    INNER JOIN prioridadesdespesas TP 
    ON TP.idPrioridade = TD.idPrioridade
    WHERE TD.idUsuario = :usuario";

    $params = [':usuario' => $usuarioLogin];
    $sql .= " ORDER BY TD.dataDespesa DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>