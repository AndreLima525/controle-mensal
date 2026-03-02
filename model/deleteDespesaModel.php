<?php
require_once('conn.php');

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM despesas WHERE idDespesa = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: ../view/dashboard.php?pagina=consultar");
    exit;
}
?>