<?php
    
require_once('conn.php');

function inserirCaixinha($pdo, $dados) {

    $sql = "INSERT INTO caixinhas (
                dataDeposito,
                valorDeposito,
                idPix,
                dsDeposito
            ) VALUES (
                :data,
                :valor,
                :idPix,
                :descricao
            )";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':data'    => $dados['data'],
        ':valor'  => $dados['valor'],
        ':idPix' => $dados['idPix'],
        ':descricao'  => $dados['descricao']
    ]);
}   

?>