<?php

require_once('conn.php');

$usuarioLogin = $_SESSION['idUsuario'];

date_default_timezone_set('America/Sao_Paulo');
$dataAtual = date('Y-m-d');

function buscarCategorias() {
    global $pdo;

    $sqlCategorias = "SELECT * FROM categorias";
    $stmt = $pdo->prepare($sqlCategorias);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$dadosCategorias = buscarCategorias();

function buscarPrioridades() {
    global $pdo;

    $sqlPrioridades = "SELECT * FROM prioridadesDespesas";
    $stmt = $pdo->prepare($sqlPrioridades);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$dadosPrioridades = buscarPrioridades();

function buscarPix($usuarioLogin) {
    global $pdo;

    $sqlPix = "SELECT * FROM dadospix WHERE idUsuario = :usuario";
    $params = [':usuario' => $usuarioLogin];
    $stmt = $pdo->prepare($sqlPix);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$dadosPix = buscarPix($usuarioLogin); 

foreach ($dadosPix as $dado) {

    $idPix = $dado['idPix'];
    $dsPix = $dado['dsPix'];
}

function buscarCaixinhas($usuarioLogin) {
    global $pdo;

    $sqlCaixinhas = "SELECT * FROM caixinhas TC 
                     INNER JOIN dadospix DP ON TC.idPix = DP.idPix 
                     INNER JOIN usuarios US ON US.idUsuario = DP.idUsuario
                     WHERE DP.idUsuario = :usuario";

    $params = [':usuario' => $usuarioLogin];
    $stmt = $pdo->prepare($sqlCaixinhas);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$dadosCaixinhas = buscarCaixinhas($usuarioLogin);

$totalCaixinha = 0;

foreach ($dadosCaixinhas as $dado) {
   
     $totalCaixinha += (float) $dado['valorDeposito'];
}

function buscarUsuarios() {
    global $pdo;

    $sqlUsuarios = "SELECT US.idUsuario,
                           US.nomeUsuario,
                           US.idNivelAcesso,
                           NA.dsAcesso,
                           DP.idPix,
                           DP.dsPix
                    FROM usuarios US
                    INNER JOIN nivelAcesso NA 
                        ON US.idNivelAcesso = NA.idNivelAcesso
                    LEFT JOIN dadospix DP 
                        ON DP.idUsuario = US.idUsuario";

    $stmt = $pdo->prepare($sqlUsuarios);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$dadosUsuarios = buscarUsuarios();


?>