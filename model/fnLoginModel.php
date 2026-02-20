<?php

	function buscarLogin($usuarioLogin) {
    global $pdo;

    $sql = "SELECT * FROM usuarios WHERE login = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":usuario", $usuarioLogin);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>