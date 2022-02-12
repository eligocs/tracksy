<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Databasebackup extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("bank_model");
		$this->load->library('form_validation');
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99'){
			$this->load->dbutil();   
			$backup =& $this->dbutil->backup();  
			$date = date("d_m_Y");
			$file_name = "dbbackup_". $date;
			$this->load->helper('file');
			/* $path = site_url() . "site/";
			write_file( $path, $backup); */
			$this->load->helper('download');
			force_download($file_name .'.zip', $backup);
		}else{
			redirect("404");
		}
	}
}	

?>