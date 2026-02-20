<?php
	
	session_start();

	if (isset($_GET['sair'])) {
		
		session_unset();
		session_destroy();

		header("location:../view/index.php");

	} elseif (!isset($_SESSION['usuario'])) {

		header("location:../view/index.php");
	}
?>