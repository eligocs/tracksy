<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Msg_center extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("marketing_model");
	}
	
	//Index page
	public function index(){
		$user = $this->session->userdata('logged_in');
		$data["user_id"] = $user["user_id"];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95' ){
			$data["msg_listing"] = $this->global_model->getdata("msg_log", array( "del_status" => 0 ));
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('msg_center/sms_list', $data);
			$this->load->view('inc/footer');
		}else if( $user['role'] == '96' ){
			$data["msg_listing"] = $this->global_model->getdata("msg_log", array( "del_status" => 0, "agent_id" => $user["user_id"] ));
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('msg_center/sms_list', $data);
			$this->load->view('inc/footer');
		}else{	
			redirect("dashboard");
		}
	}
	
	/* Send message to users */
	public function send_new_message(){
		$user = $this->session->userdata('logged_in');
		$data["user_id"]	= $user["user_id"];
		$data["user_role"] 	= $user["role"];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95' || $user['role'] == '96' ){
			$data["marketing_category"] = $this->marketing_model->getAllCategory();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('msg_center/send_new_message', $data);
			$this->load->view('inc/footer');
		}else{	
			redirect("dashboard");
		}
	}
	
	
	/* Resend message to pending customers */
	public function resend_message(){
		$user = $this->session->userdata('logged_in');
		$agent_id	= $user["user_id"];
		$data["user_id"]	= $agent_id;
		$data["user_role"] 	= $user["role"];
		$newsletter_id = trim($this->uri->segment(3));
		$data["marketing_category"] = $this->marketing_model->getAllCategory();
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '95'){
			$where = array("id" => $newsletter_id, "del_status" => 0);
			$newsletters = $this->global_model->getdata( "msg_log", $where );
			$data['newsletter'] = $newsletters;
			if($newsletters){ 	
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('msg_center/resend_message', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("msg_log");
			}	
		}else if($user['role'] == '96'){
			$where = array("id" => $newsletter_id, "del_status" => 0, "agent_id" => $agent_id );
			$newsletters = $this->global_model->getdata( "msg_log", $where );
			$data['newsletter'] = $newsletters;
			if($newsletters){ 	
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('msg_center/resend_message', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("msg_log");
			}	
		}else{
			redirect("dashboard");
		}	
	}
	
	//delete newsletters
	public function update_msg_del_status(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("msg_log", $where);
		if( $result){
			$this->session->set_flashdata('success',"Message Deleted Successfully.");
			$res = array('status' => true, 'msg' => "Message delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* Get City data By state Id */	
	public function cityListByStateId(){
		if(isset($_POST["state"])){
			$state_id = trim($_POST["state"]);
			// Define state and city array
			$city_list = get_city_list( $state_id );
			if( $city_list ){
				if($state_id !== ''){
					echo '<option value="">Select City</option>';
					foreach($city_list as $city){
						echo '<option value="'.$city->id.'">'.$city->name.'</option>';
					}
				}
			}else{
				echo '<option value="Other">Other City!</option>';
			}
			die();
		}
	}
	
	/* Get All Customers */	
	public function ajax_get_marketing_ref_cus_list(){
		$user = $this->session->userdata('logged_in');
		$user_role = $user["role"];
		$user_id = $user["user_id"];
		
		if(isset($_POST["cat"]) && !empty( $_POST["cat"] ) ){
			$limit = 1000;
			$state 		= trim($_POST["state"]);
			$city 		= trim($_POST["city"]);
			$cat		= trim($_POST["cat"]);
			$res_html 	= "";
			
			$news_id	= isset( $_POST['news_id'] ) && !empty( $_POST['news_id'] ) ? $_POST['news_id'] : "";
			//if newsletter id exists
			if( !empty( $news_id  ) ){
				$where_n = array( "id" => $news_id, "del_status" => 0 );
				$newsletters = $this->global_model->getdata( "msg_log", $where_n );
				$sent_contacts = isset($newsletters[0]) && !empty($newsletters[0]->sent_to) ? explode(",", $newsletters[0]->sent_to) : ""; 
			}else{
				$sent_contacts = array();
			}
			
			//get data by cat id
			if( $cat == "all_leads" ){ //all leads
				$table = "customers_inquery";
				$contact_key = "customer_contact";
				$name_key 	= "customer_name";
				$where = array("del_status" => 0 , "customer_contact !=" => "" );
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}else if( $cat == "working_lead" ){ // working leads
				$table 			= "customers_inquery";
				$contact_key 	= "customer_contact";
				$name_key 		= "customer_name";
				$where = array("del_status" => 0 , "customer_contact !=" => "", "cus_status" => 0 );
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}else if( $cat == "booked_lead" ){ //booked leads
				$table = "customers_inquery";
				$contact_key = "customer_contact";
				$name_key 	= "customer_name";
				$where = array("del_status" => 0 , "customer_contact !=" => "", "lead_close_status" => 0, "cus_status" => 9 );
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}else if( $cat == "declined_lead" ){ //declined leads
				$table = "customers_inquery";
				$contact_key = "customer_contact";
				$name_key 	= "customer_name";
				$where = array("del_status" => 0 , "customer_contact !=" => "", "cus_status" => 8 );
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}else if( $cat == "closed_lead" ){
				$table = "customers_inquery";
				$contact_key = "customer_contact";
				$name_key 	= "customer_name";
				$where = array("del_status" => 0 , "customer_contact !=" => "", "lead_close_status" => 1 );
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}else if( $cat == "process_lead" ){
				$name_key 	= "customer_name";
				$table = "customers_inquery";
				$contact_key = "customer_contact";
				$get_data = $this->marketing_model->get_process_leads_lists( $sent_contacts, $limit );
			}else if( $cat == "reference" ){
				$name_key 	= "name";
				$table = "reference_customers";
				$contact_key = "contact";
				$where = array("del_status" => 0 , "contact !=" => "" );
				if( !empty( $state ) ){ $where["state"] = $state; }
				if( !empty( $city ) ){ $where["city"] = $city; }
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}else{
				$name_key 	= "name";
				$table = "marketing";
				$contact_key = "contact_number";
				$where = array( "cat_id" => $cat, "del_status"	=> 0, "contact_number !=" => "" );
				if( !empty( $state ) ) $where["state"] = $state;
				if( !empty( $city ) ) $where["city"] = $city;
				$get_data = $this->marketing_model->get_customer_contact_list( $table, $where, $contact_key, $sent_contacts, $limit );
			}
			
			//if data exists
			if( !empty( $get_data ) ){
				$total = count( $get_data );
				$res_html .= "<div class='well'><label class='strong'>
					<input type='checkbox' id='checkAll'/> Select all</label>
					<div class=''>
						Total Records Found: <strong> {$total} </strong><br>
						<span class='red small'>Note:</span>
							<span class='small'><em> By click on select all you can select only first 1000 checkbox.</em></span>
					</div></div>";
					
					$res_html .= "<div class='mails-db' id='mails-db'>";
					$list_id = 1;
					
					foreach( $get_data as $customer ){
						//$name = $customer->name;
						$company_name = isset( $customer->company_name ) && !empty( $customer->company_name ) ? $customer->company_name : "";
						$name = !empty( $company_name ) ? $company_name : $customer->$name_key;
						$contact = $customer->$contact_key;
						
						$res_html .= "<div class='all_mails'><input id='emaillist_{$list_id}' required class='form-control cus_emails' name='customer_contacts[]' type='checkbox' value='{$contact}' /><label for='emaillist_{$list_id}'>{$contact} < {$name} ></label></div>";
						$list_id++;
					}
					
					$res_html .=  "</div>";	
					//$res_html .=  "<div class='clearfix'></div><a href='#' class='btn btn-success pull-right' id='loadMore'>LoadMore</a>";
					$res_html .=  "<div class='clearfix'></div><div id='emails_res'></div>";
				
				$res = array("status" => true, "msg" => "All Customers Found!", "res_html" => $res_html );
			}else{
				$res = array("status" => false, "msg" => "No customers found!");
			}
		}else{
			$res = array("status" => false, "msg" => "Invalid Request!");
		}
		die( json_encode($res) );
	}
	
	/*View MEssage*/
	public function view_message(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$newsletter_id = trim($this->uri->segment(3));
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '95'){
			$where = array("id" => $newsletter_id , "del_status" => 0);
			$data['newsletter'] = $this->global_model->getdata( "msg_log", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('msg_center/view', $data);
			$this->load->view('inc/footer');
		}else if($user['role'] == '96'){
			$where = array("id" => $newsletter_id , "del_status" => 0, "agent_id" => $user_id );
			$data['newsletter'] = $this->global_model->getdata( "msg_log", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('msg_center/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("login");
		}	
	}
	
	//Send flash text msg
	public function send_flash_text_sms(){
		$user = $this->session->userdata('logged_in');
		$user_id	= $user["user_id"];
		if( isset( $_POST['customer_contacts'] ) && !empty( $_POST['text_message'] ) ){
			//dump( $_POST );
			$mobile_numbers 	= implode( "," , $this->input->post('customer_contacts', TRUE) );
			$text_message	 	= strip_tags( $this->input->post('text_message', TRUE ));
			$action				= $this->input->post("action_type");
			//Send msg
			$insert_id = "";
			//$send_sms = pm_send_sms( 9805890367, "test" );
			$send_sms = pm_send_sms( $mobile_numbers, $text_message );
			if( $send_sms ){
				/* Save Message Log data to database */
				if( $action	== "add" ){
					$data = array(
						'message' 		=> $text_message,
						'sent_to' 		=> $mobile_numbers,
						'agent_id' 		=> $user_id,
					);
					//post on social
					$insert_id = $this->global_model->insert_data( "msg_log", $data);
				}elseif( $action == "edit" ){
					/* Update newsletter data*/
					$type = $this->security->xss_clean($this->input->post('action_type'));
					$news_id = $this->security->xss_clean($this->input->post('news_id'));
					$result = $this->marketing_model->update_data_contacts_log($news_id, $mobile_numbers);
				}
				
				$res = array("status" => true, "msg" => "Message Send Successfully.!", "insert_id" => $insert_id);
				$this->session->set_flashdata('success',"Message Send Successfully.");
				//redirect("msg_center");
			}else{
				$this->session->set_flashdata('error',"Message Not Send.");
				$res = array("status" => false, "msg" => "Message Not Sent!");
			}
		}else{
			$this->session->set_flashdata('error',"Invalid action.");
			$res = array("status" => false, "msg" => "Invalid action.");
			//redirect("msg_center/send_new_message");
		}	
		die( json_encode($res) );
	}
	
	//Test MEssage
	/* public function test_sms(){
		pm_send_sms( "9805890367", "sdfsdfsd" );
	} */
	
	//Testing delivered report msg91 Push DLR
	public function msg_delivered_report(){
		
	//	$result = file_get_contents('http://requestbin.fullcontact.com/upq4p1up');
	//	echo $result;
	//	die;
		var_dump( http_response_code() );
		die;
		$request = $_REQUEST["data"];
		$jsonData = json_decode($request,true);
		
		foreach($jsonData as $key => $value){
			 // request id
			$requestID = $value['requestId'];
			$userId = $value['userId'];
			$senderId = $value['senderId'];
			foreach($value['report'] as $key1 => $value1)
			{
				//detail description of report
				$desc = $value1['desc'];
				// status of each number
				$status = $value1['status'];
				// destination number
				$receiver = $value1['number'];
				//delivery report time
				$date = $value1['date'];
				
				$insert_data = array(
					"request_id" => $requestID,
					"user_id" => $userId,
					"sender_id" => $senderId,
					"date" => $date,
					"receiver" => $receiver,
					"status" => $status,
					"description" => $desc,
				);
				$query = $this->global_model->insert_data( "msg_log", $insert_data );
			}
		}
	}	

}	

?>