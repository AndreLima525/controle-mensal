<?php
    require_once('../model/conn.php');

    $id = $_POST['id'];

    $valor = $_POST['valor'];
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);

    $sql = "UPDATE despesas 
    SET dsDespesa = ?, valorDespesa = ?, dataDespesa = ?
    WHERE idDespesa = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['descricao'],
        $valor,
        $_POST['data'],
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