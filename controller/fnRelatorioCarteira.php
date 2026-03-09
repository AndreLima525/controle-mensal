<?php
session_start();
ob_start();

require('../lib/fpdf.php');
include_once('../model/fnRelatoriosModel.php');

$usuarioLogin = $_SESSION['idUsuario'] ?? null;
$DT_ConsultaI = $_POST['DT_ConsultaI'] ?? null;
$DT_ConsultaT = $_POST['DT_ConsultaT'] ?? null;

// Busca os dados filtrados
$dadosCarteira = getCarteiraFiltrada(
    $usuarioLogin,
    $DT_ConsultaI,
    $DT_ConsultaT
);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relatorio da Carteira',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(0,8,'Periodo: '.date('d/m/Y', strtotime($DT_ConsultaI)).
                 ' ate '.date('d/m/Y', strtotime($DT_ConsultaT)),
           0,1,'L');

$pdf->Ln(5);

// Cabeçalho da tabela
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,10,utf8_decode('Data'),1);
$pdf->Cell(80,10,utf8_decode('Descrição'),1);
$pdf->Cell(50,10,utf8_decode('Usuário'),1);
$pdf->Cell(30,10,utf8_decode('Valor'),1);
$pdf->Ln();

$pdf->SetFont('Arial','',11);
$total = 0;

foreach($dadosCarteira as $d){

    $pdf->Cell(30,10,date('d/m/Y', strtotime($d['dataDeposito'])),1);
    $pdf->Cell(80,10,utf8_decode($d['dsDeposito']),1);
    $pdf->Cell(50,10,utf8_decode($d['nomeUsuario']),1);
    $pdf->Cell(30,10,'R$ '.number_format($d['valorDeposito'],2,',','.'),1,0,'R');

    $pdf->Ln();
    $total += $d['valorDeposito'];
}

$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'Total: R$ '.number_format($total,2,',','.'),1,1,'R');

ob_end_clean();
$pdf->Output('I','relatorio_carteira.pdf');
exit;
?>