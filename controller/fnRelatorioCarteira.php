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


$pdf->Image('../images/logoAtomtech.jpeg',10,10,30); 


$pdf->SetXY(50, 15); 
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Relatorio da Carteira',0,1,'L');


$pdf->SetFont('Arial','',10);
$pdf->SetXY(50, 25);

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

// Cabeçalho da tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(50,50,50); // cinza escuro
$pdf->SetTextColor(255,255,255); // branco
$pdf->Cell(30,10,utf8_decode('Data'),1,0,'C',true);
$pdf->Cell(80,10,utf8_decode('Descrição'),1,0,'C',true);
$pdf->Cell(50,10,utf8_decode('Usuário'),1,0,'C',true);
$pdf->Cell(30,10,utf8_decode('Valor'),1,1,'C',true);


$pdf->SetFont('Arial','',11);
$total = 0;

$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0); // texto preto
$fill = false; // alterna cor

$total = 0;
foreach($dadosCarteira as $d){
    $pdf->SetFillColor(240,240,240); // cinza claro
    $pdf->Cell(30,10,date('d/m/Y', strtotime($d['dataDeposito'])),1,0,'C',$fill);
    $pdf->Cell(80,10,utf8_decode($d['dsDeposito']),1,0,'L',$fill);
    $pdf->Cell(50,10,utf8_decode($d['nomeUsuario']),1,0,'L',$fill);
    $pdf->Cell(30,10,'R$ '.number_format($d['valorDeposito'],2,',','.'),1,1,'R',$fill);

    $fill = !$fill; // alterna cor
    $total += $d['valorDeposito'];
}

$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(160,10,'Total',1,0,'R',true);
$pdf->Cell(30,10,'R$ '.number_format($total,2,',','.'),1,1,'R',true);

ob_end_clean();
$pdf->Output('I','relatorio_carteira.pdf');
exit;
?>