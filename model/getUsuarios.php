<?php

function buscarUsuarios() {
    global $pdo;

    $sqlUsuarios = "SELECT US.idUsuario,
    US.nomeUsuario,
    US.idNivelAcesso,
    US.stAtivo,
    NA.dsAcesso,
    DP.idPix,
    DP.dsPix
    FROM usuarios US
    INNER JOIN nivelAcesso NA 
    ON US.idNivelAcesso = NA.idNivelAcesso
    INNER JOIN dadospix DP 
    ON DP.idUsuario = US.idUsuario";

    $stmt = $pdo->prepare($sqlUsuarios);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$dadosUsuarios = buscarUsuarios();

?>