<?php
    require_once('../model/conn.php');
    
    session_start();
    
    $id = $_GET['id'];

    $idUsuario = $_SESSION['idUsuario'];

    $sql = "UPDATE despesas

    SET IC_Paga = ?

    WHERE idDespesa = ? AND idUsuario = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([

        'S',        
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