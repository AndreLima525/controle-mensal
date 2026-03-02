<?php
include_once('../model/fnIncluirDespesaModel.php');

if (isset($_POST['novo'])) {


	$dados = [
		'usuario'    => $_SESSION['idUsuario'],
		'categoria'  => $_POST['categoria'],
		'prioridade' => $_POST['prioridade'],
		'descricao'  => $_POST['dsDespesa'],
		'valor'      => str_replace(',', '.', $_POST['valorDespesa']),
		'data'       => $_POST['data']
	];

	if (empty($dados)) {

		echo "<script>alert('Existem campos não preenchidos!');</script>";
	} else {

		$inseriu = inserirDespesa($pdo, $dados);

		if ($inseriu) {
			echo "<script>alert('Despesa inserida com sucesso!');</script>";
		} else {
			echo "<script>alert('Erro ao cadastrar despesa!');</script>";
		}

	}

}

if (isset($_POST['voltar'])) {
	header('location:../view/dashboard.php');
}

?>