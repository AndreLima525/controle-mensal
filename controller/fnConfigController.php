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
?>