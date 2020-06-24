<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

require_once('../../../connection/connection.php');

session_start();

date_default_timezone_set("Asia/Colombo");


// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

/**
 * 
 *//**
  * 
  */

class pdf extends TCPDF
{
	public function Header() {
		//logo
		$image_file = K_PATH_IMAGES.'logo.png';
		$this->Image($image_file, 45, 15, 120, '', 'PNG', '', 'R', false, 300, '', false, false, 0, false, false, false);

		$this->SetFont('helvetica', 'B', 11);
		$this->Ln(2);
		$this->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');
        
        $this->SetFont('helvetica', 'B', 11);
		$this->Ln(25);
		$this->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');

		date_default_timezone_set("Asia/Colombo");
		$tDate=date('Y-m-d H:i:s');

		$this->Ln(1);
		$this->SetFont('Courier', '', 11);
		$this->Cell(180, 5, 'Printed Date: '.$tDate, 0, 1, 'R');


		$this->Ln(7);
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(180, 5, 'Division Officer List Report', 0, 1, 'C');
        
	}

	public function Footer() {
		
		$this->SetY(-45);

		$this->Image(K_PATH_IMAGES.'signature.png', 152, 256, 28, '', 'PNG', '', 'R', false, 300, '', false, false, 0, false, false, false);
		
		$this->Ln(5);
		$this->SetFont('Courier', '', 12);

		$this->Cell(12, 15, '       '.date('d/m/Y'), 0, 0);
		$this->Cell(114, 1, '', 0, 0);
		$this->Cell(52, 1, '', 0, 1);

		$this->SetFont('times', '', 12);

		$this->Cell(12, 1, '       _____________________', 0, 0);
		$this->Cell(115, 1, '', 0, 0);
		$this->Cell(51, 1, '_____________________', 0, 1);

		$this->Cell(12, 1, '                        Date', 0, 0);
		$this->Cell(114, 1, '', 0, 0);
		$this->Cell(52, 1, 'Commissioner of Elections', 0, 1);
		
		
		$this->SetFont('Courier', '', 10);
		$this->Ln(3);
		$this->Cell(180, 3, '_____________________________________________________________________________________', 0, 1, 'C');
		$this->Cell(180, 3, ' - Report of Division Officer List from FVS -', 0, 1, 'C');
		$this->Cell(205, 3, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, 1, 'C');

	}


}

// create new PDF document
$pdf = new PDF('p', 'mm', 'A4');

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FVS');
$pdf->SetTitle('Division Officer List Report');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set some language-dependent strings (optional)
/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}*/

// ---------------------------------------------------------

$pdf->AddPage();

$pdf->SetFont('times', 'B', 10);


$i = 1;
$max = 15;

$pdf->Ln(45);
$pdf->SetFont('times', 'B', 10);
$pdf->SetFillColor(111, 44, 145);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(15, 7, 'ID', 0, 0, 'C', 1);
$pdf->Cell(45, 7, 'Division', 0, 0, 'C', 1);
$pdf->Cell(45, 7, 'District', 0, 0, 'C', 1);
$pdf->Cell(30, 7, 'NIC', 0, 0, 'C', 1);
$pdf->Cell(45, 7, 'Name', 0, 1, 'C', 1);

if($_SESSION['administration_role']=='AEO'){
    $query2 = "SELECT a.`divi_id`, d.`name` AS 'd_name', dis.`id` AS 'dis_id', dis.`name` AS 'dis_name', v.`nic`, v.`name`, v.`contact` FROM `division_officer` a, `voter` v, `division` d, `district` dis WHERE v.`nic` = a.`nic` AND a.`divi_id` = d.`id` AND d.`dist_id` = dis.`id` AND dis.`id` = {$_SESSION['administration_working_at']}";
} else {
    $query2 = "SELECT a.`divi_id`, d.`name` AS 'd_name', dis.`id` AS 'dis_id', dis.`name` AS 'dis_name', v.`nic`, v.`name`, v.`contact` FROM `division_officer` a, `voter` v, `division` d, `district` dis WHERE v.`nic` = a.`nic` AND a.`divi_id` = d.`id` AND d.`dist_id` = dis.`id`";
}

$result = $con->query($query2);

while ($row = $result->fetch_assoc()) {

    $pdf->SetFont('Courier', '', 10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(2);
    $pdf->Cell(15, 4, $row['divi_id'], 0, 0, 'C');
    $pdf->MultiCell(45, 4, $row['d_name'], 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(45, 4, "(".$row['dis_id'].") ".$row['dis_name'], 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(30, 4, $row['nic'], 0, 'L', 0, 0, '', '', true);
    $pdf->Cell(45, 4, $row['name'], 0, 1, 'L');
    $pdf->Cell(180, 2, '_____________________________________________________________________________________', 0, 1, 'C');

    if(($i%$max) == 0) {

        $pdf->AddPage();
        $pdf->Ln(45);
        $pdf->SetFont('times', 'B', 10);
        $pdf->SetFillColor(111, 44, 145);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(15, 7, 'ID', 0, 0, 'C', 1);
        $pdf->Cell(45, 7, 'Division', 0, 0, 'C', 1);
        $pdf->Cell(45, 7, 'District', 0, 0, 'C', 1);
        $pdf->Cell(30, 7, 'NIC', 0, 0, 'C', 1);
        $pdf->Cell(45, 7, 'Name', 0, 1, 'C', 1);

    }

    $i++;
}


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Division Officer List Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
