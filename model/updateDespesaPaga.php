<?php
    require_once('../model/conn.php');

    $id = $_GET['id'];

    $sql = "UPDATE despesas

    SET IC_Paga = ?

    WHERE idDespesa = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([

        'S',        
        $id
        
    ]);

    echo "

    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL= ../view/dashboard.php?pagina=consultar'>
    <script type=\"text/javascript\">
    alert(\"Registro editado com sucesso!\");
    </script>                            
    ";
    exit;
?>