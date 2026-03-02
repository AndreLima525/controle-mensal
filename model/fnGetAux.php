<?php
    
    require_once('conn.php');

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

    $dadosCategorias = buscarCategorias();
    $dadosPrioridades = buscarPrioridades();

?>