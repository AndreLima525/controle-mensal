<?php
require_once('conn.php');

function buscarUsuariosFiltrados($nomeUsuario = null, $stAtivo = null) {
    global $pdo;

    $sql = "SELECT 
        US.idUsuario,
        US.nomeUsuario,
        US.idNivelAcesso,
        US.stAtivo,
        NA.dsAcesso,
        DP.idPix,
        DP.dsPix
    FROM usuarios US
    INNER JOIN nivelAcesso NA 
        ON US.idNivelAcesso = NA.idNivelAcesso
    LEFT JOIN dadospix DP 
        ON DP.idUsuario = US.idUsuario
    WHERE 1=1";

    $params = [];

    if (!empty($nomeUsuario)) {
        $sql .= " AND US.nomeUsuario LIKE :nome";
        $params[':nome'] = "%".$nomeUsuario."%";
    }

    if ($stAtivo !== null && $stAtivo !== '') {
        $sql .= " AND US.stAtivo = :stAtivo";
        $params[':stAtivo'] = $stAtivo;
    }

    $sql .= " ORDER BY US.nomeUsuario ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>