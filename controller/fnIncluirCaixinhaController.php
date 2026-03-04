<?php

include_once('../model/fnIncluirCaixinhaModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$valor = $_POST['valorDeposito'];

	$valor = str_replace('.', '', $valor);
	$valor = str_replace(',', '.', $valor);

	$dados = [

		'data'  => $_POST['data'],
		'valor'      => $valor,
		'idPix'  => $_POST['idPix'],		
		'descricao'       => $_POST['dsDeposito']
	];

	if (empty($dados)) {

		echo "<script>alert('Existem campos não preenchidos!');</script>";
	} else {

		$inseriu = inserirCaixinha($pdo, $dados);

		if ($inseriu) {

			echo "

			<META HTTP-EQUIV=REFRESH CONTENT = '0;URL='>
			<script type=\"text/javascript\">
			alert(\"Depósito incluído com sucesso!\");
			</script>                            
			";

		} else {
			echo "<script>alert('Erro ao cadastrar despesa!');</script>";
		}

	}
}

?>