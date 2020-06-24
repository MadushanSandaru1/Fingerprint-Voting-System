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
		$this->Cell(180, 3, ' - Report of Election Results from FVS -', 0, 1, 'C');
		$this->Cell(205, 3, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, 1, 'C');

	}


}

// create new PDF document
$pdf = new PDF('p', 'mm', 'A4');

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FVS');
$pdf->SetTitle('Election Results Report');
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

//election info
$schedule_status_query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` AND s.`id` = {$_GET['scheduleId']}";

$schedule_status_result_set = mysqli_query($con,$schedule_status_query);

if (mysqli_num_rows($schedule_status_result_set) >= 1) {
    $election_info = mysqli_fetch_assoc($schedule_status_result_set);
    $election_info_date_from = $election_info['date_from'];
    $election_info_name_en = $election_info['name_en'];
    $election_info_type = $election_info['type'];
}

//summery info
//votes info
$registered_vote_count_query = "SELECT COUNT(*) AS 'votersCount' FROM `voter` WHERE `is_died` = 0 AND `is_deleted` = 0 AND TIMESTAMPDIFF(YEAR, `b_day`, '".substr($election_info['date_from'],0,10)."') >= 18";

$registered_vote_count_result_set = mysqli_query($con,$registered_vote_count_query);

if (mysqli_num_rows($registered_vote_count_result_set) >= 1) {
    $registered_vote_count = mysqli_fetch_assoc($registered_vote_count_result_set);
}

$vote_count_query = "SELECT count(v.`id`) AS 'declaredTotal', SUM(case when v.`candidate_id` IS NULL then 1 else 0 end) AS 'rejectedTotal' FROM `vote` v WHERE v.`schedule_id` = {$_GET['scheduleId']}";

$vote_count_result_set = mysqli_query($con,$vote_count_query);

if (mysqli_num_rows($vote_count_result_set) >= 1) {
    $vote_count = mysqli_fetch_assoc($vote_count_result_set);
}

$pdf->AddPage();

$pdf->Ln(23);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(180, 5, $election_info_name_en." (".substr($election_info_date_from,0,7).")", 0, 1, 'C');

$pdf->Ln(3);
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(180, 5, 'Election Results - All Island', 0, 1, 'C');

//Registered votes and Declared votes
$pdf->Ln(5);
$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(111, 44, 145)));
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(111, 44, 145);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(40, 6, 'Registered Votes', 1, 0, 'L', 1);
$pdf->SetFont('Courier', 'B', 12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(111, 44, 145);
$pdf->Cell(50, 6, $registered_vote_count['votersCount'], 1, 0, 'R', 1);
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(111, 44, 145);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(40, 6, 'Declared Votes', 1, 0, 'L', 1);
$pdf->SetFont('Courier', 'B', 12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(111, 44, 145);
$pdf->Cell(50, 6, $vote_count['declaredTotal'], 1, 1, 'R', 1);

//Valid votes and Rejected votes
$pdf->Ln(1);
$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(111, 44, 145)));
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(111, 44, 145);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(40, 6, 'Valid Votes', 1, 0, 'L', 1);
$pdf->SetFont('Courier', 'B', 12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(111, 44, 145);
$pdf->Cell(50, 6, $vote_count['declaredTotal']-$vote_count['rejectedTotal'], 1, 0, 'R', 1);
$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(111, 44, 145);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(40, 6, 'Rejected Votes', 1, 0, 'L', 1);
$pdf->SetFont('Courier', 'B', 12);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(111, 44, 145);
$pdf->Cell(50, 6, $vote_count['rejectedTotal'], 1, 1, 'R', 1);

//result by party
$pdf->Ln(5);
$pdf->SetFont('times', 'B', 10);
$pdf->SetFillColor(111, 44, 145);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(100, 7, 'Party', 0, 0, 'C', 1);
$pdf->Cell(20, 7, 'Percentage', 0, 0, 'C', 1);
$pdf->Cell(60, 7, 'No. of Votes', 0, 1, 'C', 1);

//no of votes group by party
$query = "SELECT p.`id`, p.`name_en`, p.`symbol`, p.`color`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY p.`id` ORDER BY COUNT(a.`id`) DESC";

$result = $con->query($query);

$i = 1;
$max = 14;

while ($row = $result->fetch_assoc()) {

    $pdf->SetFont('Courier', '', 10);
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(2);
    
    $pdf->MultiCell(100, 4, $row['id']." - ".$row['name_en'], 0, 'L', 0, 0, '', '', true);
    $pdf->Cell(20, 4, round($row['no_of_votes']/($vote_count['declaredTotal']-$vote_count['rejectedTotal'])*100,2)."%", 0, 0, 'C');
    $pdf->Cell(60, 4, $row['no_of_votes'], 0, 1, 'R');
    
    $pdf->Cell(180, 2, '_____________________________________________________________________________________', 0, 1, 'C');

    if(($i%$max) == 0) {

        $pdf->AddPage();
        
        $pdf->Ln(23);
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(180, 5, $election_info_name_en." (".substr($election_info_date_from,0,7).")", 0, 1, 'C');

        $pdf->Ln(3);
        $pdf->SetFont('helvetica', '', 14);
        $pdf->Cell(180, 5, 'Election Results - All Island', 0, 1, 'C');

        $pdf->Ln(5);
        $pdf->SetFont('times', 'B', 10);
        $pdf->SetFillColor(111, 44, 145);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(100, 7, 'Party', 0, 0, 'C', 1);
        $pdf->Cell(20, 7, 'Percentage', 0, 0, 'C', 1);
        $pdf->Cell(60, 7, 'No. of Votes', 0, 1, 'C', 1);

    }

    $i++;
}


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Election Results Report - All Island.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
