<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Pagenotfound extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
	}
	
	public function index(){
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('404');
		$this->load->view('inc/footer'); 
	}
	
}	

?>