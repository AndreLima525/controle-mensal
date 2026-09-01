<?php
session_start();
ob_start();

require('../lib/fpdf.php');
include_once('../model/fnRelatoriosModel.php');

function convert($txt){
    return mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8');
}

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

// Título
$pdf->SetXY(50, 15); 
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,convert('Relatório da Carteira'),0,1,'L');

// Período
$pdf->SetFont('Arial','',10);
$pdf->SetXY(50, 25);

$periodo = '';
if (!empty($DT_ConsultaI) && !empty($DT_ConsultaT)) {
    $periodo = date('d/m/Y', strtotime($DT_ConsultaI)) .
               ' até ' . date('d/m/Y', strtotime($DT_ConsultaT));
} elseif (!empty($DT_ConsultaI)) {
    $periodo = 'A partir de ' . date('d/m/Y', strtotime($DT_ConsultaI));
} elseif (!empty($DT_ConsultaT)) {
    $periodo = 'Até ' . date('d/m/Y', strtotime($DT_ConsultaT));
} else {
    $periodo = 'Todos os registros';
}

$pdf->Cell(0,8,convert('Período: '.$periodo),0,1,'L');

$pdf->Ln(10);

// Cabeçalho da tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(50,50,50);
$pdf->SetTextColor(255,255,255);

$pdf->Cell(30,10,convert('Data'),1,0,'C',true);
$pdf->Cell(80,10,convert('Descrição'),1,0,'C',true);
$pdf->Cell(50,10,convert('Usuário'),1,0,'C',true);
$pdf->Cell(30,10,convert('Valor'),1,1,'C',true);

// Conteúdo
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);
$fill = false;
$total = 0;

foreach($dadosCarteira as $d){
    $pdf->SetFillColor(240,240,240);

    $pdf->Cell(30,10,date('d/m/Y', strtotime($d['dataDeposito'])),1,0,'C',$fill);
    $pdf->Cell(80,10,convert($d['dsDeposito']),1,0,'L',$fill);
    $pdf->Cell(50,10,convert($d['nomeUsuario']),1,0,'L',$fill);
    $pdf->Cell(30,10,'R$ '.number_format($d['valorDeposito'],2,',','.'),1,1,'R',$fill);

    $fill = !$fill;
    $total += $d['valorDeposito'];
}

// Total
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(200,200,200);

$pdf->Cell(160,10,convert('Total'),1,0,'R',true);
$pdf->Cell(30,10,'R$ '.number_format($total,2,',','.'),1,1,'R',true);

ob_end_clean();
$pdf->Output('I','relatorio_carteira.pdf');
exit;
?>