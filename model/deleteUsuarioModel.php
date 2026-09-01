<?php
require_once('conn.php');

session_start();

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    if (isset($_SESSION['acesso']) && $_SESSION['acesso'] == 1) {

        $sql = "UPDATE usuarios SET stAtivo = 0 WHERE idUsuario = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        header("Location: ../view/dashboard.php?pagina=config");
        exit;

    } else {

        header("Location: ../view/dashboard.php?pagina=config");
        exit;
    }


}
?>