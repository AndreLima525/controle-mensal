<?php
    require_once('../model/conn.php');

    session_start();
    
    $id = $_POST['id'];

    $idUsuario = $_SESSION['idUsuario'];

    $valor = $_POST['valor'];
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);

    $sql = "UPDATE despesas 
    SET dsDespesa = ?, valorDespesa = ?, dataDespesa = ?
    WHERE idDespesa = ? AND idUsuario = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['descricao'],
        $valor,
        $_POST['data'],
        $id,
        $idUsuario
    ]);

    echo "

    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL= ../view/dashboard.php?pagina=consultar'>
    <script type=\"text/javascript\">
    alert(\"Registro editado com sucesso!\");
    </script>                            
    ";
    exit;
?>