<?php

require_once('../model/configSenhaModel.php');
require_once('../model/fnAlterarSenhaPixModel.php');

if (isset($_POST['alterar'])) {

	$novaSenha = $_POST['novaSenha'];

	$novaSenhaConfirm = $_POST['novaSenhaConfirm'];

	$dsBancoPix = $_POST['dsBancoPix'];

	$dsPix = $_POST['dsPix'];

	$idPix = $_POST['idPix'];

	if ($novaSenha == $novaSenhaConfirm) {

		try {
			
			$novaSenhaAtl = password_hash($novaSenha, PASSWORD_DEFAULT);
			$idUsuario = $_SESSION['idUsuario'];

			$alterSenha = configSenha($novaSenhaAtl, $idUsuario);
			$alterPix = alterarPix($idPix, $dsBancoPix, $dsPix, $idUsuario);

			echo "<script>alert('Dados alterados com sucesso!');</script>";
			

		} catch (Exception $e) {
			echo $e;
		}

		

	} else {

		echo "<script>alert('As senhas não são iguais!');</script>";
	}
}

?>

