<?php

require_once('conn.php');

function configSenha($novaSenhaAtl, $idUsuario) {

	global $pdo;

	$sqlConfigSenha = "UPDATE usuarios
	SET senha = ?, idPAcesso = 1
	WHERE idUsuario = ?";

	$stmt = $pdo->prepare($sqlConfigSenha);
	return $stmt->execute([$novaSenhaAtl, $idUsuario]);
}



?>