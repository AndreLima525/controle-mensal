<?php
require_once('conn.php');

session_start();

if (isset($_GET['id'])) {

    $id = ($_GET['id']);
    $idUsuario = $_SESSION['idUsuario'];

    $sql = "DELETE FROM despesas WHERE idDespesa = ? AND idUsuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id,$idUsuario]);

    header("Location: ../view/dashboard.php?pagina=consultar");
    exit;
}
?>