<?php

require_once('../model/configSenhaModel.php');

if (isset($_POST['atualizarSenha'])){

	session_start();

	$idUsuario = $_SESSION['idUsuario'];

	$novaSenha = $_POST['novaSenha'];

	$novaSenhaConfirm = $_POST['novaSenhaConfirm'];

	if ($novaSenha == $novaSenhaConfirm) {

		$novaSenhaAtl = password_hash($novaSenha, PASSWORD_DEFAULT);

		$inseriu = configSenha($novaSenhaAtl, $idUsuario);

		$_SESSION['idPAcesso'] == 1;

		echo "
                           
                     <META HTTP-EQUIV=REFRESH CONTENT = '0;URL= ../view/dashboard.php?pagina=home'>
                        <script type=\"text/javascript\">
                            alert(\"Senha atualizda com sucesso!\");
                        </script>                            
                    ";
			
		

	} else {

		echo "<script>alert('As senhas não são iguais!');</script>";

	}
}
?>