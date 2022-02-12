<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		if ( $this->session->userdata('logged_in')){
			redirect("dashboard");
		}
		$this->load->model('login_model');
		$this->load->helper('cookie');
		$this->load->helper('captcha');
	}

	public function index(){
		$data['sec_key'] = md5($this->config->item("encryption_key"));
		$this->load->view('users/login', $data);
	}
	
	//validation
	public function validation(){
		$sec_key = $this->input->post("sec_key");
		$enc_key = md5($this->config->item("encryption_key"));
		if( $enc_key !== $sec_key){
			$this->session->set_flashdata('error_msg','Security Error!');
			redirect('login');
			die();
		}else{
			$username = strip_tags($this->input->post("username"), true);
			$password = trim($this->input->post("password", true));
			$var = $this->check_database($username,$password);
			echo $var;
		}	
	}
	public function validationlogin($username,$password){
		$var = $this->check_database($username,$password);
		echo $var;
	}
	public function check_database($username,$password){  
	
		$userStatus = "";
		$useremail = $username; 
		$result = $this->login_model->login($useremail, $password); //query the database
		$totalUser = $result->num_rows();
		//check cookies
		if(isset($_COOKIE['login_count'])){
			$log_count = $_COOKIE['login_count'];
		}else{
			$log_count = "";
		}	
		if( $log_count >= 3){ 
			$this->session->set_flashdata('error_msg','You\'ve had your 4 failed attempts at logging in and now are banned for 10 minutes. Try again later! ' );
			redirect("login");
			exit;
		}else{	
			if($totalUser == 1){
				foreach($result->result() as $row)
				$userStatus = $row->user_status;
				$del_status = $row->del_status;
				
				if( $del_status == 1 ){
					$this->session->set_flashdata('error_msg','Your account is deleted. Please contact Administrator.');
					redirect('login');
					exit;
				}
				if($userStatus == "active"){
					$sess_array = array();
					foreach($result->result() as $row){
						$sess_array = array(
							'user_id'	 	=> $row->user_id,	
							'useremail' 	=>  $row->email,
							'fname' 		=> $row->first_name,
							'lname' 		=>  $row->last_name,
							'status' 		=>  $row->user_status,
							'role' 			=>  $row->user_type,
							'profile_image' =>  $row->user_pic,
							'last_login' 	=>  $row->last_login,
							'login_ip' 		=>  $row->login_ip,
						);
						$this->session->set_userdata('logged_in', $sess_array);
					}
				
					//set cookie	
					setcookie("login_count",0,0);
					$url =  isset( $_POST['reffere_url'] ) && !empty($_POST['reffere_url']) ? $_POST['reffere_url'] : base_url()."dashboard";
					
					$loginData = array('last_login' => date('Y-m-d h:i:s A'), 'login_ip' => get_user_ip() );
					if ( $this->global_model->update_data('users', array('user_id' => $row->user_id ), $loginData ) ) {
						redirect($url);
						exit;
					}
					//redirect($url);
					
				}elseif($userStatus == "inactive"){
					$this->session->set_flashdata('error_msg','Your account is Inactive. Please contact Administrator.');
					redirect('login');
				}elseif($userStatus == "block"){
					$this->session->set_flashdata('error_msg','Your account is Blocked. Please contact Administrator.');
					redirect('login');
				}
				
			}else{
				if(isset($_COOKIE['login_count'])){
					if($_COOKIE['login_count'] < 3){
						$attempts = $_COOKIE['login_count'] + 1;
						$r_attempts = 4 - $attempts;
						setcookie('login_count', $attempts, time()+60*10); //set the cookie for 10 minutes with the number of attempts stored
						$this->session->set_flashdata('error_msg','Incorrect Username or password. You have only ' . $r_attempts . ' attempts remaining.');
					} else{
						
						$this->session->set_flashdata('error_msg','You\'ve had your 4 failed attempts at logging in and now are banned for 10 minutes. Try again later! ');
					}
				}else{
					setcookie('login_count', 1, time()+60*10); //set the cookie for 10 minutes with the initial value of 1
					$this->session->set_flashdata('error_msg','Incorrect Username or password. You have only 3 attempts left.');
				}
				redirect('login');
				exit;
			}
		}
	}
	
	//Send mail forgot password
	public function ajax_forgot_password(){
		$this->load->helper('email');
		$this->load->helper('path');
		
		$sec_key = $this->input->post("sec_key");
		$enc_key = md5($this->config->item("encryption_key"));
		if( $enc_key !== $sec_key){
			$res = array('status' => false, 'msg' => "Security Error! Please try again.");
			die( json_encode($res) );
		}
		$email = strip_tags($this->input->post("email"));
		if( empty($email)  || !valid_email( $email ) ){
			$res = array('status' => false, 'msg' => "Please enter valid email id!");
			die( json_encode($res) );
		}
		//Check email id	
		$exists = $this->login_model->isEmailExist($email);
		if( $exists ){
			//update password
			$newpass = getTokenKey(8);
			$result = $this->login_model->update_forgot_password($email, $newpass); //query the database
			if( $result ){
				$mail_html = "";
				$mail_html .= "<html><head>
				<style>
				body{font-family: 'Roboto', sans-serif; color:#555555;}
					.mail-logo {background: #364150;  text-align: center;    padding: 20px 0;}
				</style></head><body><div class='mail-container'>";
				$logo_url = base_url() . "site/images/trackv2-logo.png";
				$mail_html .= "<div class='mail-logo'><img src='{$logo_url }'></div>";
				$mail_html .= "<p>Password successfully changed.<br> Your New Password is ' <strong>{$newpass}</strong> '. You can change your password in my profile section in dashboard.<br>Thanks and Regards<br>trackitinerary Pvt. Lmt.</p>";
				$mail_html .= "</body></html>";
				
				/*Get admin email */
				$admin_email = admin_email();
				$this->email
					->from($admin_email, 'trackitinerary Pvt. Ltd.')
					->to( $email )
					->subject('Password Changed <spampuranyatra> confirmation Mail.')
					->message( $mail_html )
					->set_mailtype('html');
				
				$sent_mail = $this->email->send(); 
				if( $sent_mail ){
					$res = array('status' => true, 'msg' => "Password successfully sent to your email id.Please check email in your inbox. If you not recieve email in inbox check in spam or junk folder.");
					die( json_encode($res) );
				}else{
					$res = array('status' => false, 'msg' => "Error! Please try again later.");
					die( json_encode($res) );
				}
			}
		}else{
			$res = array('status' => false, 'msg' => "Email id does not exists.Please enter registered email id Or contact your administrator!");
			die( json_encode($res) );
		}
	}
}
