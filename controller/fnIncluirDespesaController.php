<?php
include_once('../model/fnIncluirDespesaModel.php');

if (isset($_POST['novo'])) {


	$valor = $_POST['valorDespesa'];

	$valor = str_replace('.', '', $valor);
	$valor = str_replace(',', '.', $valor);

	$dados = [
		'usuario'    => $_SESSION['idUsuario'],
		'categoria'  => $_POST['categoria'],
		'prioridade' => $_POST['prioridade'],
		'descricao'  => $_POST['dsDespesa'],
		'valor'      => $valor,
		'data'       => $_POST['data']
	];

	if (empty($dados)) {

		echo "<script>alert('Existem campos não preenchidos!');</script>";
	} else {

		$inseriu = inserirDespesa($pdo, $dados);

		if ($inseriu) {

			echo "
                           
                     <META HTTP-EQUIV=REFRESH CONTENT = '0;URL= ../view/dashboard.php?pagina=consultar'>
                        <script type=\"text/javascript\">
                            alert(\"Despesa incluída com sucesso!\");
                        </script>                            
                    ";

		} else {
			echo "<script>alert('Erro ao cadastrar despesa!');</script>";
		}

	}

}

if (isset($_POST['voltar'])) {
	header('location:../view/dashboard.php');
}

?>