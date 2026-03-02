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

    if (!empty($param['DT_ConsultaI'])) { // script para filtrar por data inicio e final
                $data_despesa_inicio = implode("-", array_reverse(explode("/", $param['DT_ConsultaI']))); // Aqui o nome da variavel inicial  
                $query .= " AND ";
                $query .= " ( date(TD.DT_Inicio) >= '" . $data_despesa_inicio . "'"; // Aqui vai o parametro de data, o nome do campo da tabela
                if (!empty($param['DT_ConsultaT'])) {
                    $data_final = implode("-", array_reverse(explode("/", $param['DT_ConsultaT']))); // Aqui o nome da variavel Final  
                    $query .= " AND ( date(TD.DT_Inicio) <= '" . $data_final . "'";
                    $query .= " OR TD.DT_Inicio IS NULL )";
                } else {
                    $query .= " AND date(TD.DT_Inicio) <= '" . $data_despesa_inicio . "'";
                }
                $query .= " ) ";
            }

    
    if (!empty($prioridade)) {
        $sql .= " AND TD.idPrioridade = :prioridade";
        $params[':prioridade'] = $prioridade;
    }

    if (!empty($categoria)) {
        $sql .= " AND TD.idCategoria = :categoria";
        $params[':categoria'] = $categoria;
    }

    $sql .= " ORDER BY TD.dataDespesa DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>