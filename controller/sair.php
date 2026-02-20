<?php
	
	session_start();

	if (isset($_SESSION['usuario'])) {
		
		session_unset();
		session_destroy();

		header("location:../view/index.php");

	} else {

		header("location:../view/index.php");
	}
?>