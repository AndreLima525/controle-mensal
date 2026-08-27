<?php

require_once('conn.php');

function getDespesasFiltradas($usuarioLogin, $DT_ConsultaI = null, $DT_ConsultaT = null, $prioridade = null, $categoria = null) {
	global $pdo;

	$sql = "SELECT 
	TD.idDespesa,
	TD.dataDespesa,
	TD.dsDespesa,
	TD.valorDespesa,
	TP.dsPrioridade,
	TC.dsCategoria
	FROM despesas TD
	INNER JOIN categorias TC 
	ON TC.idCategoria = TD.idCategoria
	INNER JOIN prioridadesDespesas TP 
	ON TP.idPrioridade = TD.idPrioridade
	WHERE TD.idUsuario = :usuario";

	$params = [':usuario' => $usuarioLogin];

    if (!empty($DT_ConsultaI)) {
	    $sql .= " AND TD.dataDespesa >= :dataInicio";
	    $params[':dataInicio'] = $DT_ConsultaI;
	}

	if (!empty($DT_ConsultaT)) {
	    $sql .= " AND TD.dataDespesa <= :dataFinal";
	    $params[':dataFinal'] = $DT_ConsultaT;
	}

	if ($prioridade !== null && $prioridade !== '') {
		$sql .= " AND TD.idPrioridade = :prioridade";
		$params[':prioridade'] = (int)$prioridade;
	}

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
	TP.dsPrioridade,
	TC.dsCategoria
	FROM despesas TD
	INNER JOIN categorias TC 
	ON TC.idCategoria = TD.idCategoria
	INNER JOIN prioridadesDespesas TP 
	ON TP.idPrioridade = TD.idPrioridade
	WHERE TD.idUsuario = :usuario";

	$params = [':usuario' => $usuarioLogin];
	$sql .= " ORDER BY TD.dataDespesa DESC";

	$stmt = $pdo->prepare($sql);
	$stmt->execute($params);

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCarteiraFiltrada($usuarioLogin, $DT_ConsultaI = null, $DT_ConsultaT = null){
    global $pdo;

    $sql = "SELECT 
                TC.dataDeposito, 
                TC.dsDeposito, 
                TC.valorDeposito,
                US.nomeUsuario
            FROM caixinhas TC
            INNER JOIN dadospix DP ON TC.idPix = DP.idPix
            INNER JOIN usuarios US ON US.idUsuario = DP.idUsuario
            WHERE DP.idUsuario = :usuario";

    $params = [':usuario' => $usuarioLogin];

    // FILTRO DATA INICIAL
    if (!empty($DT_ConsultaI)) {
        $sql .= " AND TC.dataDeposito >= :dataInicio";
        $params[':dataInicio'] = $DT_ConsultaI;
    }

    // FILTRO DATA FINAL
    if (!empty($DT_ConsultaT)) {
        $sql .= " AND TC.dataDeposito <= :dataFinal";
        $params[':dataFinal'] = $DT_ConsultaT;
    }

    $sql .= " ORDER BY TC.dataDeposito DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>