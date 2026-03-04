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

?>