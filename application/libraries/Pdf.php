<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/TCPDF/tcpdf.php';
class Pdf extends TCPDF{
    function __construct(){
        parent::__construct();
		//add font run once
		//TCPDF_FONTS::addTTFfont( K_PATH_FONTS . 'font.ttf', 'TrueTypeUnicode', "" , 32);
    }
	
	//Page header
    public function Header() {
		if ($this->page == 1) {
			// Set font
			$this->SetFont('helvetica', 'B', 14);
			$this->SetTextColor(255,255,255);
			// $image_file = K_PATH_IMAGES.'logo.png';
			$image_file = site_url()  . 'site/images/' . getLogo();
			// set image scale factor
			$this->Rect(0, 0, 2000, 25,'F',array(),array(0,51,103));
			//#Rect(x, y, w, h, style = '', border_style = {}, fill_color = {}) ⇒ Object
			$this->Image($image_file, 8, 5, 80, 16, 'PNG', '', 'T', false, '', '', false, false, 0, false, false, false);
			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

			//  $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Title
			$this->SetFont('helvetica', '', 10);
			// $this->Cell(0, 7, 'Phone No: 0177-000', 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$this->Ln();
			$this->Cell(0, 7, 'Email: info@trackitinerary.com', 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$this->Ln();
			$this->Cell(0, 7, 'Website: www.trackitinerary.com', 0, false, 'R', 0, '', 0, false, 'M', 'M');
			
			// set margins
			$this->SetMargins(5, PDF_MARGIN_TOP, 5);
			$this->SetHeaderMargin(10);
			$this->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
		}else{
			// set margins
			$this->SetMargins(5, 5, 5);
			$this->SetHeaderMargin(5);
			$this->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
		}	
    }
	
	

    // Page footer
    public function Footer() {
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell( 0,10, "info@trackitinerary.org", 0, true, 'R', 0, '', 0, false, 'T', 'M');
		
    }
}