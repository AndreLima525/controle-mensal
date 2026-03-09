<?php

include_once('../model/fnRelatoriosModel.php');
require('../lib/fpdf.php');

session_start();


$usuarioLogin = $_SESSION['idUsuario'] ?? null;
$DT_ConsultaI = $_POST['DT_ConsultaI'] ?? null;
$DT_ConsultaT = $_POST['DT_ConsultaT'] ?? null;
$prioridade   = $_POST['prioridade'] ?? null;
$categoria    = $_POST['categoria'] ?? null;

$dadosDespesas = getDespesasFiltradas(
	$usuarioLogin,
	$DT_ConsultaI,
	$DT_ConsultaT,
	$prioridade,
	$categoria
);

$pdf = new FPDF();
$pdf->AddPage();

// Logo no canto superior esquerdo
$pdf->Image('../images/logoAtomtech.jpeg',10,10,30); // X=10, Y=10, Largura=30

// Move o cursor para a direita da logo
$pdf->SetXY(50, 15); // X=50 (logo termina em 40), Y=15 para alinhar verticalmente
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relatorio de Despesas',0,1,'L');

// Período abaixo do título
$pdf->SetFont('Arial','',10);
$pdf->SetXY(50, 25); // Ajusta Y para não sobrepor o título

$periodo = '';
if (!empty($DT_ConsultaI) && !empty($DT_ConsultaT)) {
    $periodo = date('d/m/Y', strtotime($DT_ConsultaI)) .
               ' ate ' . date('d/m/Y', strtotime($DT_ConsultaT));
} elseif (!empty($DT_ConsultaI)) {
    $periodo = 'A partir de ' . date('d/m/Y', strtotime($DT_ConsultaI));
} elseif (!empty($DT_ConsultaT)) {
    $periodo = 'Até ' . date('d/m/Y', strtotime($DT_ConsultaT));
} else {
    $periodo = 'Todos os registros';
}

$pdf->Cell(0,8,'Periodo: '. $periodo,0,1,'L');

$pdf->Ln(10); // espaço antes da tabela

$pdf->SetFont('Arial','B',12);

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(50,50,50);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(30,10,utf8_decode('Data'),1,0,'C',true);
$pdf->Cell(70,10,utf8_decode('Descrição'),1,0,'C',true);
$pdf->Cell(40,10,utf8_decode('Categoria'),1,0,'C',true);
$pdf->Cell(30,10,utf8_decode('Prioridade'),1,0,'C',true);
$pdf->Cell(20,10,utf8_decode('Valor'),1,1,'C',true);



$pdf->SetFont('Arial','',11);

$total = 0;

$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0); // texto preto
$fill = false; // alterna cor

foreach($dadosDespesas as $d){
    $pdf->SetFillColor(240,240,240);
    $pdf->Cell(30,10,date('d/m/Y', strtotime($d['dataDespesa'])),1,0,'C',$fill);
    $pdf->Cell(70,10,utf8_decode($d['dsDespesa']),1,0,'L',$fill);
    $pdf->Cell(40,10,utf8_decode($d['dsCategoria']),1,0,'L',$fill);
    $pdf->Cell(30,10,utf8_decode($d['dsPrioridade']),1,0,'L',$fill);
    $pdf->Cell(20,10,'R$ '.number_format($d['valorDespesa'],2,',','.'),1,1,'R',$fill);

    $fill = !$fill;
    $total += $d['valorDespesa'];
}

$pdf->SetFont('Arial','B',12);


$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(140,10,'Total',1,0,'R',true);
$pdf->Cell(50,10,'R$ '.number_format($total,2,',','.'),1,1,'R',true);

$pdf->Output();

exit;

?>