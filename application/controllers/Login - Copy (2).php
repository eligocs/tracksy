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
	
	//login for username and password
	public function snewlogin(){
		$data['sec_key'] = md5($this->config->item("encryption_key"));
		$this->load->view('users/login_with_username_password', $data);
	}
	
	/*
	* LOGIN SYSTEM WITH USERNAME AND PASSWORD
	*/
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
				
				//IF user deleted
				if( $del_status == 1 ){
					$this->session->set_flashdata('error_msg','Your account is deleted. Please contact Administrator.');
					redirect('login');
					exit;
				}
				
				//if not admin or manager
				//if( $row->user_type != 99 && $row->user_type != 98 ){
				//	$this->session->set_flashdata('error_msg',"You can't login with this form. Please contact Administrator.");
				//	redirect('login');
				//	exit;
				//}
				
				if($userStatus == "active"){
					
					//check if user login in today
					$this->__check_agents__standard_login_time( $row );
					
					//end check if user login in today
					
					$sess_array = array();
					foreach($result->result() as $row){
						$sess_array = array(
							'user_id'	 	=> 	$row->user_id,	
							'useremail' 	=>  $row->email,
							'fname' 		=> 	$row->first_name,
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
					
					$loginData = array(
						'last_login' 			=> date('Y-m-d h:i:s A'),
						'login_ip' 				=> get_user_ip().
						'login_request' 		=>  "0",
						'login_request_date' 	=>  "0000-00-00 00:00:00",
					);
					
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
	
	
	/*
	* LOGIN SYSTEM WITH USERNAME AND OTP
	*/
	
	/* Login with Mobile Number */
	public function ajax_login_with_mob(){
		$this->load->library('sendotp');
		$user_name = strip_tags( $this->input->post("username") );
		$sec_key = $this->input->post("sec_key");
		$enc_key = md5($this->config->item("encryption_key"));
		/* check for security Check */
		if( $enc_key !== $sec_key){
			$res = array('status' => false, 'msg' => "Security Error! Please try again.");
			die( json_encode($res) );
		}
		/* check if mobile is empty */
		if( empty($user_name) ){
			$res = array('status' => false, 'msg' => "Please enter valid User Name");
			die( json_encode($res) );
		}
		/* get user if exists */
		$where = array( "user_name" =>  trim($user_name), "del_status" => 0 );
		$get_user = $this->global_model->getdata( "users", $where );
		
		if( $get_user ){
			//Count Users
			$count_res = count($get_user);
			if( $count_res == 1 ){
				$user_info 		= $get_user[0];
				$user_status 	= $user_info->user_status;
				$mobile_number	= $user_info->mobile_otp;
				
				//if mobile number does not exits
				if( empty( $mobile_number ) ){
					$res = array('status' => false, 'msg' => "Your contact does not exists. Please contact your administrator." );
					die( json_encode( $res ) );
				}
				
				
				if($user_status == "active"){
					//$res = array('status' => true, 'msg' => $user_info);
					//send otp
					$req = array("mobileNumber" => $mobile_number, "countryCode" => 91);
					$send_otp = $this->sendotp->generateOTP($req);
					/* if otp sent successfully */
					if( $send_otp == "OTP SENT SUCCESSFULLY" ){
						$res = array('status' => true, 'msg' => "Otp send successfully.", "mobile_number" => $mobile_number );
					}else{
						$res = array('status' => false, 'msg' => $send_otp );
					}
				}elseif($user_status == "inactive"){
					$res = array('status' => false, 'msg' => "Your account is inactive. Please contact your administrator." );
				}elseif($user_status == "block"){
					$res = array('status' => false, 'msg' => "Your account is Blocked. Please contact your administrator." );
				}
			}else{
				$res = array('status' => false, 'msg' => "Multi user exists against this number. Please contact your administrator.");
			}
		}else{
			$res = array('status' => false, 'msg' => "User name does not exists. Please contact your manager.");
		}
		die( json_encode($res) );
	}
	
	/* Verify OTP */
	public function ajax_verify_otp(){
		$this->load->library('sendotp');
		$user_name		 = strip_tags( $this->input->post("user_name") );
		$mobile_number	 = strip_tags( $this->input->post("mobileNumber") );
		$otp			 = strip_tags( $this->input->post("verifyOtp") );
		
		$sec_key = $this->input->post("sec_key");
		$enc_key = md5($this->config->item("encryption_key"));
		/* check for security Check */
		if( $enc_key !== $sec_key){
			$res = array('status' => false, 'msg' => "Security Error! Please try again.");
			die( json_encode($res) );
		}
		
		/* check if mobile and otp is empty */
		if( empty($mobile_number) ||  empty($otp) ){
			$res = array('status' => false, 'msg' => "Please enter OTP");
		}else{
			//send otp
			$req = array("mobileNumber" => trim($mobile_number), "countryCode" => 91, "oneTimePassword" => trim($otp));
			$verfiy_otp = $this->sendotp->verifyBySendOtp($req);
			/* if otp Verify successfully */
			if( $verfiy_otp == "NUMBER VERIFIED SUCCESSFULLY" ){
				/* get user if exists */
				$where = array( "user_name" =>  $user_name, "del_status" => 0, "mobile_otp" => $mobile_number );
				$get_user = $this->global_model->getdata( "users", $where );
				
				/* store user data in session */
				$sess_array = array(
					'user_id' 		=> 	$get_user[0]->user_id,	
					'useremail' 	=>  $get_user[0]->email,
					'fname' 		=> 	$get_user[0]->first_name,
					'lname' 		=>  $get_user[0]->last_name,
					'status' 		=>  $get_user[0]->user_status,
					'role' 			=>  $get_user[0]->user_type,
					'profile_image' =>  $get_user[0]->user_pic,
					'last_login' 	=>  $get_user[0]->last_login,
					'login_ip'		=>  $get_user[0]->login_ip,
				);
				$this->session->set_userdata('logged_in', $sess_array);
				
				//user current ip
				$site_name	= get_site_name();
				$login_ip	= get_user_ip();
				$curr_time 	= date('Y-m-d h:i:s A');
				
				$url 		=  isset( $_POST['reffere_url'] ) && !empty($_POST['reffere_url']) ? $_POST['reffere_url'] : base_url()."dashboard";
				//$loginData 	= array('last_login' => $curr_time, 'login_ip' => $login_ip );
				
				$loginData = array(
					'last_login' 			=> $curr_time,
					'login_ip' 				=> $login_ip.
					'login_request' 		=>  "0",
					'login_request_date' 	=>  "0000-00-00 00:00:00",
				);
				
				//update user
				$this->global_model->update_data('users', array('user_id' => $get_user[0]->user_id ), $loginData );
				
				//Send notification email to admin ::1
				$dev_ips = array( "103.77.215.84", "103.77.215.85", "::1" );
				if( !in_array( $login_ip, $dev_ips ) ){
					$user_n 	= $get_user[0]->user_name;
					$fname 		= $get_user[0]->first_name;
					$to 		= admin_email();
					$subject 	= "{$user_n} Login to {$site_name}.";
					$msg 		= "{$user_n} login to {$site_name} at {$curr_time}.<br>";
					$msg 		.= "User Name: {$user_n} <br>";
					$msg 		.= "Name: {$fname} <br>";
					$msg 		.= "IP Address: {$login_ip}";
					$sent_mail 	= sendEmail($to, $subject, $msg);
				}
				
				$res = array('status' => true, 'msg' => "NUMBER VERIFIED SUCCESSFULLY.", "redirect_url" => $url );
			}else{
				$res = array('status' => false, 'msg' => $verfiy_otp );
			}
		}	
		die( json_encode($res) );
	}
	
	//Resend otp
	public function ajax_resend_otp(){
		$this->load->library('sendotp');
		$mobile_number	 = strip_tags( $this->input->post("mobileNumber") );
		$sec_key = $this->input->post("sec_key");
		$enc_key = md5($this->config->item("encryption_key"));
		/* check for security Check */
		if( $enc_key !== $sec_key){
			$res = array('status' => false, 'msg' => "Security Error! Please try again.");
			die( json_encode($res) );
		}
		
		/* check if mobile and otp is empty */
		if( empty($mobile_number) ){
			$res = array('status' => false, 'msg' => "Mobile number not found.");
		}else{
			//send otp
			$req = array("mobileNumber" => trim($mobile_number), "countryCode" => 91 );
			$verfiy_otp = $this->sendotp->resendOtp($req);
			/* if otp Verify successfully */
			if( $verfiy_otp == "otp_sent_successfully" ){
				$res = array('status' => true, 'msg' => "OTP Resend successfully. Please wait.." );
			}else{
				$res = array('status' => false, 'msg' => $verfiy_otp );
			}
		}	
		die( json_encode($res) );
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
		$exists = $this->login_model->isUserExist("email", $email);
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
	
	//validate user login
	private function __check_agents__standard_login_time( $row ){
		dump( $row );
		$get_user_role = $row->user_type;
		$curr_date 	= date("Y-m-d");
		$last_login = !empty($row->last_login) ? date( "Y-m-d", strtotime($row->last_login) ) : "";
		
		$current_time = date("h:i a");
		$login_start_time 	= "09:30 am";
		$login_over_time 	= "10:00 am";
		$current_time_f 	= DateTime::createFromFormat('H:i a', $current_time);
		$login_start_time_f = DateTime::createFromFormat('H:i a', $login_start_time);
		$login_over_time_f	= DateTime::createFromFormat('H:i a', $login_over_time);
		
		if( $current_time_f > $login_start_time_f && $current_time_f < $login_over_time_f ){
			echo 'Now you can login.';
		}else{
			echo 'You need to manager permission to login.';
		}
		
		if( $curr_date != $last_login ){
			echo "Login first time today";
		}
		
		echo $last_login;
		
		$this->session->set_flashdata('error_msg','Your account is Blocked. Please contact Administrator.');
		//redirect('login');
		die; 
	}
	
}
