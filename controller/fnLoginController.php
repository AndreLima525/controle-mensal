<?php

require_once('../model/conn.php');
include_once('../model/fnLoginModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$usuarioLogin = $_POST['usuario'];
	$senhaLogin = $_POST['senha'];

	$dados = buscarLogin($usuarioLogin);

	if (!empty($dados)) {

		$idUsuario   = $dados['idUsuario'];
		$nome   = $dados['nomeUsuario'];
		$usuario = $dados['login'];
		$senha   = $dados['senha'];
		$acesso  = $dados['idNivelAcesso'];
		$ativo   = $dados['stAtivo'];
		$idPAcesso   = $dados['idPAcesso'];

		if ($usuarioLogin == $usuario && password_verify($senhaLogin, $senha) && $ativo == 1) {

			session_start();

			$_SESSION['idUsuario'] = $idUsuario;
			$_SESSION['usuario'] = $nome;
			$_SESSION['acesso'] = $acesso;

			if ($idPAcesso != 0 ) {

				header("location:dashboard.php");

			} else {
				header("location:configSenha.php");
			}
			
		} elseif ($ativo != 1) {
			
			echo "<script>alert('Usuário sem permissão de acesso!');</script>";

		} elseif ($usuarioLogin != $usuario || $senhaLogin != $senha) {
			
			echo "<script>alert('Usuário ou senha incorretos!');</script>";

		} 
		
	} else {

		echo "<script>alert('Usuário ou senha incorretos!');</script>";
	}


}
?>