<?php
require_once('../model/conn.php');

$idUsuario = $_POST['id'];
$nome = $_POST['descricao'];
$nivel = $_POST['idNivelAcesso'];
$pix = $_POST['dsPix'];
$idPix = $_POST['idPix'];

// Atualiza usuário
$sqlUsuario = "UPDATE usuarios
               SET nomeUsuario = ?, idNivelAcesso = ?, stAtivo = 1
               WHERE idUsuario = ?";

$stmt = $pdo->prepare($sqlUsuario);
$stmt->execute([$nome, $nivel, $idUsuario]);

// Atualiza PIX
if(!empty($idPix)){

    $sqlPix = "UPDATE dadospix
               SET dsPix = ?
               WHERE idPix = ?";

    $stmt = $pdo->prepare($sqlPix);
    $stmt->execute([$pix, $idPix]);

}else{

    // Caso usuário não tenha pix 
    if(!empty($pix)){
        $sqlPix = "INSERT INTO dadospix (idUsuario, dsPix)
                   VALUES (?, ?)";

        $stmt = $pdo->prepare($sqlPix);
        $stmt->execute([$idUsuario, $pix]);
    }
}

echo "
<META HTTP-EQUIV=REFRESH CONTENT='0;URL= ../view/dashboard.php?pagina=config'>
<script>
alert('Usuário editado com sucesso!');
</script>
";
exit;
?>