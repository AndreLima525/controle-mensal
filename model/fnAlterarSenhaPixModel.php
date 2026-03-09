<?php

require_once('conn.php');

function alterarPix ($idPix, $dsBancoPix, $dsPix, $idUsuario) {

    global $pdo;

    if(!empty($idPix)){

        $sqlPix = "UPDATE dadospix
        SET  dsBancoPix = ? , dsPix = ?
        WHERE idPix = ?";

        $stmt = $pdo->prepare($sqlPix);
        $stmt->execute([$dsBancoPix, $dsPix, $idPix]);

    }else{

    // Caso usuário não tenha pix 
        if(!empty($pix)){
            $sqlPix = "INSERT INTO dadospix (idUsuario, dsBancoPix, dsPix)
            VALUES (?, ?, ?)";

            $stmt = $pdo->prepare($sqlPix);
            $stmt->execute([$idUsuario, $dsBancoPix, $pix]);
        }
    }
}

?>