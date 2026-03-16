<?php
require_once('conn.php');

function buscarUsuariosFiltrados($nomeUsuario = null, $stAtivo = null) {
    global $pdo;

    $sql = "SELECT 
        US.idUsuario,
        US.nomeUsuario,
        US.email,
        US.idNivelAcesso,
        US.stAtivo,
        NA.dsAcesso,
        DP.dsBancoPix,
        DP.idPix,
        DP.dsPix
    FROM usuarios US
    INNER JOIN nivelacesso NA 
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

function inserirUsuario($pdo, $dados, $dadosPix) {

    try {

        $pdo->beginTransaction();

        // INSERE USUÁRIO
        $sql = "INSERT INTO usuarios (
                    nomeUsuario,
                    email,
                    login,
                    senha,
                    idNivelAcesso
                ) VALUES (
                    :nomeUsuario,
                    :email,
                    :login,
                    :senha,
                    :idNivelAcesso
                )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nomeUsuario'   => $dados['nomeUsuario'],
            ':email'   => $dados['email'],
            ':login'         => $dados['login'],
            ':senha'         => $dados['senha'],
            ':idNivelAcesso' => $dados['idNivelAcesso']
        ]);

        // PEGA O ID GERADO
        $idUsuario = $pdo->lastInsertId();

        // INSERE PIX
        if (!empty($dadosPix['dsPix'])) {

            $sqlPix = "INSERT INTO dadospix (
                           dsBancoPix,
                           dsPix,
                           idUsuario
                       ) VALUES (
                           :dsBancoPix,
                           :dsPix,
                           :idUsuario
                       )";

            $stmtPix = $pdo->prepare($sqlPix);

            $stmtPix->execute([
                ':dsBancoPix' => $dadosPix['dsBancoPix'] ?? null,
                ':dsPix'      => $dadosPix['dsPix'],
                ':idUsuario'  => $idUsuario
            ]);
        }

        $pdo->commit();

        return true;

    } catch (Exception $e) {

        $pdo->rollBack();
        return false;
    }
}

?>