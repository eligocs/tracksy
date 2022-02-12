<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("settings_model");
		$this->load->helper('email');
	}
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ){
			$data['settings'] = $this->global_model->getdata("settings");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('settings/settings_view',$data);
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
		
	}
	
	//Ajax request update General Settings
	public function ajax_updateGeneralsettings(){
		$admin_email = $this->input->post( 'inp[admin_email]');
		
		//Check email validation
		if( !valid_email( $admin_email ) ||  empty( $admin_email ) ){
			$res = array('status' => false, 'msg' => "Please enter valid admin email.");
			die(json_encode($res));
		}
		$data = $this->input->post('inp', TRUE);
		
		$online_payments = $this->input->post( 'inp[online_payments]');
		if( empty( $online_payments ) ){
			$data['online_payments'] = 0;
		}else{
			$data['online_payments'] = 1;
		}	
		
		$result = $this->settings_model->update_data("settings", $data);
		if( $result){
			$res = array('status' => true, 'msg' => "Settings updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//Ajax request update Company Info
	public function ajax_updateCompanyInfo(){
		$c_email = $this->input->post( 'inp[company_email]');
		if( !empty( $c_email ) ){
			//$data = $this->input->post('inp', TRUE);
			$data = array(
					"company_email" 	=> $this->input->post( 'inp[company_email]'),
					"company_contact"	=> $this->input->post( 'inp[company_contact]'),
					"company_info" 		=> htmlentities($this->input->post( 'inp[company_info]')),
					"who_we_are" 		=> htmlentities($this->input->post( 'inp[who_we_are]')),
					"what_we_do"		 => htmlentities($this->input->post( 'inp[what_we_do]')),
					"why_choose_us"	 	=> htmlentities($this->input->post( 'inp[why_choose_us]')),
					"tagline" 			=> htmlentities($this->input->post( 'inp[tagline]')),
				);	
			$result = $this->settings_model->update_data("settings", $data);
			if( $result){
				$res = array('status' => true, 'msg' => "Company Info updated Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
			}
		}else{
			$res = array('status' => false, 'msg' => "All Fields required");
		}	
		die(json_encode($res));
	}
	// Sms Settings
	public function sms(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99'  ){
			$data['sms_settings'] = $this->global_model->getdata("sms_settings");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('settings/sms_settings',$data);
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
		
	}
	//Ajax request update SMS General Settings
	public function ajax_updateSmsSettings(){
		$admin_email = $this->input->post( 'auth_key');
		$result = $this->settings_model->update_sms_settings();
		if( $result){
			$res = array('status' => true, 'msg' => "Settings updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	// Social Section Settings
	public function social(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' ){
			$data['social_settings'] = $this->global_model->getdata("social_api");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('settings/social_settings',$data);
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
		
	}
	//Ajax request update Social Settings
	public function ajax_updatefbsettings(){
		$data = $this->input->post('inp', TRUE);
		$result = $this->settings_model->update_data("social_api", $data);
		if( $result){
			$res = array('status' => true, 'msg' => "Settings updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	//Ajax request update Social Settings
	public function ajax_updatetwittersettings(){
		$data = $this->input->post('inp', TRUE);
		$result = $this->settings_model->update_data("social_api", $data);
		if( $result){
			$res = array('status' => true, 'msg' => "Settings updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	//homepage
	public function homepage(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' ){
			$data['data'] = $this->global_model->getdata("homepage_setting");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('homepage/addDetails',$data);
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
	}
	
	//Ajax request update login system settings
	public function ajax_updateLoginInfo(){
		$id = $this->input->post( 'inp[id]');
		if( !empty( $id ) ){
			$post_data = $this->input->post( 'standard_login');
			$is_activated = $this->input->post( 'standard_login[activated]');
			
			if( empty( $is_activated ) ){
				$post_data['activated'] = 0;
			}else{
				$post_data['activated'] = 1;
			}
			
			$data = array(
				"standard_login"  => serialize( $post_data ),
			);	
			
			$result = $this->settings_model->update_data("settings", $data);
			
			if( $result){
				$res = array('status' => true, 'msg' => "Settings updated Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
			}
		}else{
			$res = array('status' => false, 'msg' => "All Fields required");
		}	
		die(json_encode($res));
	}
}	

?>