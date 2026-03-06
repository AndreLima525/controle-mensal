<?php
	
	include_once('../model/fnConfigModel.php');

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  
    $nomeUsuario = $_POST['nome'] ?? null;
    $stAtivo = $_POST['stAtivo'] ?? null;
    
    $dadosUsuarios = buscarUsuariosFiltrados( $nomeUsuario, $stAtivo);

} else {

	$nomeUsuario = null;
	$stAtivo = null;
	
	$dadosUsuarios = buscarUsuariosFiltrados( $nomeUsuario, $stAtivo);
}

if (isset($_POST['novo'])) {
	
	$dados = [

		'nomeUsuario'  => $_POST['nomeUsuario'],
		'login'      => $_POST['login'],
		'senha'  => $_POST['senha'],		
		'idNivelAcesso'=> $_POST['idNivelAcesso']
	];

	$dadosPix = [

		'dsBancoPix' => $_POST['dsBancoPix'],
		'dsPix' => $_POST['dsPix']
	];

	$inseriu = inserirUsuario($pdo, $dados, $dadosPix);

	if ($inseriu) {

			echo "

			<META HTTP-EQUIV=REFRESH CONTENT = '0;URL='>
			<script type=\"text/javascript\">
			alert(\"Usuário cadastrado com sucesso!\");
			</script>                            
			";

		} else {
			echo "<script>alert('Erro ao cadastrar usuário!');</script>";
		}

}
?>