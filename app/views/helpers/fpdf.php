<?php 
App::import('Vendor', 'fpdf/fpdf');
if (!defined('PARAGRAPH_STRING')) define('PARAGRAPH_STRING', '~~~');
class fpdfHelper extends FPDF {
	var $helpers = array();
	var $title;
/**
 * undocumented function
 *
 * @param string $options 
 * @return void
 * @access public
 */
	function __construct($options) {
		parent::__construct('P', 'mm', 'A4'); 
	}
/**
 * undocumented function
 *
 * @param string $orientation 
 * @param string $unit 
 * @param string $format 
 * @return void
 * @access public
 */
	function setup($orientation = 'P', $unit = 'mm', $format = 'A4') {
		$this->FPDF($orientation, $unit, $format);
	}
/**
 * undocumented 
 *
 * @access public
 */
	function fpdfOutput ($name = 'page.pdf', $destination = 's') {
		return $this->Output($name, $destination);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function Header() {
		// $this->Image(WWW_ROOT.DS.'img/logo.png',10,8,33);  
		// you can use jpeg or pngs see the manual for fpdf for more info
		$this->SetFont('Arial','B',15);
		$this->Cell(80);
		$this->Cell(30,10,$this->title,1,0,'C');
		$this->Ln(20);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function Footer() {
		$this->SetY(-15);
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(0,10,'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}
/**
 * undocumented function
 *
 * @param string $header 
 * @param string $data 
 * @return void
 * @access public
 */
	function basicTable($header,$data) {
		foreach($header as $col) {
			$this->Cell(40,7,$col,1);
		}
		$this->Ln();

		foreach ($data as $row) {
			foreach ($row as $col) {
				$this->Cell(40,6,$col,1);
			}
			$this->Ln();
		}
	}
}
?>