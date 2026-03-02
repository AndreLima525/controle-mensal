<?php

require_once('conn.php');

function inserirDespesa($pdo, $dados) {

    $sql = "INSERT INTO despesas (
                idUsuario,
                idCategoria,
                idPrioridade,
                dsDespesa,
                valorDespesa,
                dataDespesa
            ) VALUES (
                :usuario,
                :categoria,
                :prioridade,
                :descricao,
                :valor,
                :data
            )";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':usuario'    => $dados['usuario'],
        ':categoria'  => $dados['categoria'],
        ':prioridade' => $dados['prioridade'],
        ':descricao'  => $dados['descricao'],
        ':valor'      => $dados['valor'],
        ':data'       => $dados['data']
    ]);
}