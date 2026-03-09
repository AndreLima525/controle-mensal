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

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relatorio de Despesas',0,1,'C');

$pdf->SetFont('Arial','',10);

$pdf->Cell(0,8,'Periodo: '.date('d/m/Y', strtotime($DT_ConsultaI)).
                 ' ate '.date('d/m/Y', strtotime($DT_ConsultaT)),
           0,1,'L');
$pdf->Ln(5);

$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);

$pdf->Cell(30,10,utf8_decode('Data'),1);
$pdf->Cell(70,10,utf8_decode('Descricao'),1);
$pdf->Cell(40,10,utf8_decode('Categoria'),1);
$pdf->Cell(30,10,utf8_decode('Prioridade'),1);
$pdf->Cell(20,10,utf8_decode('Valor'),1);

$pdf->Ln();

$pdf->SetFont('Arial','',11);

$total = 0;

foreach($dadosDespesas as $d){

    $pdf->Cell(30,10,date('d/m/Y', strtotime($d['dataDespesa'])),1);
    $pdf->Cell(70,10,utf8_decode($d['dsDespesa']),1);
    $pdf->Cell(40,10,utf8_decode($d['dsCategoria']),1);
    $pdf->Cell(30,10,utf8_decode($d['dsPrioridade']),1);
    $pdf->Cell(20,10,'R$ '.number_format($d['valorDespesa'],2,',','.'),1,0,'R');

    $pdf->Ln();

    $total += $d['valorDespesa'];
}

$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);

$pdf->Cell(190,10,'Total: R$ '.number_format($total,2,',','.'),1,1,'R');

$pdf->Output();

exit;

?>