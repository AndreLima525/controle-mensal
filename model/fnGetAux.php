<?php
    
require_once('conn.php');

$usuarioLogin = $_SESSION['idUsuario'];

function buscarCategorias() {
    global $pdo;

    $sqlCategorias = "SELECT * FROM categorias";
    $stmt = $pdo->prepare($sqlCategorias);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarPrioridades() {
    global $pdo;

    $sqlPrioridades = "SELECT * FROM prioridadesDespesas";
    $stmt = $pdo->prepare($sqlPrioridades);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarPix($usuarioLogin) {
    global $pdo;

    $sqlPix = "SELECT * FROM dadospix WHERE idUsuario = :usuario";
    $params = [':usuario' => $usuarioLogin];
    $stmt = $pdo->prepare($sqlPix);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    $dadosCategorias = buscarCategorias();
    $dadosPrioridades = buscarPrioridades();

?>