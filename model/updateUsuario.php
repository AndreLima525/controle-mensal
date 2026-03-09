<?php
require_once('../model/conn.php');

$idUsuario = $_POST['id'];
$nome = $_POST['descricao'];
$nivel = $_POST['idNivelAcesso'];
$pix = $_POST['dsPix'];
$dsBancoPix = $_POST['dsBancoPix'];
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
               SET  dsBancoPix = ? , dsPix = ?
               WHERE idPix = ?";

    $stmt = $pdo->prepare($sqlPix);
    $stmt->execute([$dsBancoPix, $pix, $idPix]);

}else{

    // Caso usuário não tenha pix 
    if(!empty($pix)){
        $sqlPix = "INSERT INTO dadospix (idUsuario, dsBancoPix, dsPix)
                   VALUES (?, ?, ?)";

        $stmt = $pdo->prepare($sqlPix);
        $stmt->execute([$idUsuario, $dsBancoPix, $pix]);
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