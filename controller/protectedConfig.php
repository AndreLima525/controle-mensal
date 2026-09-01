<?php
	
	if ($_SESSION['acesso'] != 1) {

		header('location:../view/dashboard.php?pagina=home');
		exit;
	}

?>