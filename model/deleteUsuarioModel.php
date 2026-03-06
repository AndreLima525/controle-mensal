<?php
    require_once('conn.php');

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $sql = "UPDATE usuarios SET stAtivo = 0 WHERE idUsuario = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        header("Location: ../view/dashboard.php?pagina=config");
        exit;
    }
?>