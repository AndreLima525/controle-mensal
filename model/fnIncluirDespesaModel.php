<?php

require_once('conn.php');

function inserirDespesa($pdo, $dados) {

    $sql = "INSERT INTO despesas (
                idUsuario,
                idCategoria,
                idPrioridade,
                dsDespesa,
                valorDespesa,
                IC_Paga,
                dataDespesa
            ) VALUES (
                :usuario,
                :categoria,
                :prioridade,
                :descricao,
                :valor,
                :IC_Paga,
                :data
            )";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':usuario'    => $dados['usuario'],
        ':categoria'  => $dados['categoria'],
        ':prioridade' => $dados['prioridade'],
        ':descricao'  => $dados['descricao'],
        ':valor'      => $dados['valor'],
        ':IC_Paga'      => 'N',
        ':data'       => $dados['data']
    ]);
}