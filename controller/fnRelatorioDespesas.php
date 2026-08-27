<?php
// Inicia buffer de saída para evitar que qualquer aviso quebre o PDF
ob_start();

// Evita exibição de deprecated/notices durante a geração do PDF
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

include_once('../model/fnRelatoriosModel.php');
require('../lib/fpdf.php');

function convert($texto){
    return mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
}

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
$pdf->Image('../images/logoAtomtech.jpeg', 10, 10, 30);

// Título
$pdf->SetXY(50, 15);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10, convert('Relatório de Despesas'),0,1,'L');

// Período abaixo do título
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

$pdf->Cell(0,8, convert('Período: '). $periodo,0,1,'L');

$pdf->Ln(10); // espaço antes da tabela

// Cabeçalho da tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(50,50,50);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(30,10, convert('Data'),1,0,'C',true);
$pdf->Cell(70,10, convert('Descrição'),1,0,'C',true);
$pdf->Cell(40,10, convert('Categoria'),1,0,'C',true);
$pdf->Cell(30,10, convert('Prioridade'),1,0,'C',true);
$pdf->Cell(20,10, convert('Valor'),1,1,'C',true);

// Conteúdo da tabela
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);
$fill = false;
$total = 0;

foreach($dadosDespesas as $d){
    $pdf->SetFillColor(240,240,240);
    $pdf->Cell(30,10, date('d/m/Y', strtotime($d['dataDespesa'])),1,0,'C',$fill);
    $pdf->Cell(70,10, convert($d['dsDespesa']),1,0,'L',$fill);
    $pdf->Cell(40,10, convert($d['dsCategoria']),1,0,'L',$fill);
    $pdf->Cell(30,10, convert($d['dsPrioridade']),1,0,'L',$fill);
    $pdf->Cell(20,10,'R$ '.number_format($d['valorDespesa'],2,',','.'),1,1,'R',$fill);

    $fill = !$fill;
    $total += $d['valorDespesa'];
}

// Total
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(140,10, convert('Total'),1,0,'R',true);
$pdf->Cell(50,10,'R$ '.number_format($total,2,',','.'),1,1,'R',true);

// Gera o PDF
$pdf->Output();

ob_end_clean();
$pdf->Output('I', 'relatorio_despesas.pdf');
exit;
?>