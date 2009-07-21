<?php
$fpdf->AliasNbPages();
$fpdf->AddPage();
$fpdf->setTitle('Our Cool PDF');
$fpdf->SetFont('Times', '', 12);
for($i = 1; $i <= 40; $i++)
$fpdf->Cell(0, 10, 'Printing line number ' . $i, 0, 1);
echo $fpdf->fpdfOutput();
?>