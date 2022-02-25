<?php defined('BASEPATH') OR exit('No direct script access allowed');
   class Accounts extends CI_Controller {
   	public $table = "ac_bank_cash_account_listing";
   	public function __Construct(){
   	   	parent::__Construct();
   		validate_login();
   		$this->load->model("accounts_model");		
   		$this->load->library('form_validation');
   	}
   	
   	//account details
   	public function index(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			$data['account_listing'] = $this->global_model->getdata($this->table, array( "del_status" => 0 ) );
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/accounts_listing', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("dashboard");
   		}
   	}
   	
   	//add account details
   	public function add_account( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			if( $id ){
   				$data['account_listing'] = $this->global_model->getdata($this->table, array( 'id' => $id, 'del_status' => 0) );
   			}
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/add_account', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("dashboard");
   		}
   	}
   	
   	//ajax_add_account_details
   	public function ajax_add_account_details(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93') && isset( $_POST['account_name'] )  ){
   			$account_name 	= $this->input->post('account_name');
   			$account_type 	= $this->input->post('account_type');
   			$account_number = $this->input->post('account_number');
   			$ifsc_code 		= $this->input->post('ifsc_code');
   			$address	 	= $this->input->post('address');
   			$remarks	 	= $this->input->post('remarks');
   			$id	 			= $this->input->post('id');
   			$acc_status	 	= isset( $_POST['acc_status'] ) ? 1 : 0 ;
   			
   			//check if account_name exists
   			$check_account_name = $this->accounts_model->is_account_name_exists( 'ac_bank_cash_account_listing', "account_name", $account_name, $id );
   			if( $check_account_name ){
   				$res = array('status' => false, 'msg' => "Account name already exists!");
   				die( json_encode($res) );
   			}
   			
   			//check acc type
   			$account_number = $account_type == "bank" ? $account_number : "";
   			$ifsc_code 		= $account_type == "bank" ? $ifsc_code : "";
   			
   			//insert data
   			$data = array(
   				'account_name' => $account_name,
   				'account_type' => $account_type,
   				'account_number' => $account_number,
   				'ifsc_code' => $ifsc_code,
   				'acc_status' => $acc_status,
   				'remarks' => $remarks,
   				'address' => $address,
   				'updated_by' => $user_id,
   			);
   			
   			if( $id ){
   				$this->global_model->update_data($this->table, array("id" => $id ), $data );
   				$res = array('status' => true, 'msg' => "Account updated successfully!");	
   			}else{
   				$this->global_model->insert_data($this->table, $data );
   				$res = array('status' => true, 'msg' => "Account created successfully!");	
   			}	
   		}else{
   			$res = array('status' => false, 'msg' => "Invalid Action. Try again");
   		}	
   		die( json_encode($res) );
   	}
   	
   	
   	//delete account iti
   	public function delete_account(){
   		$id = $this->input->get('id');
   		$where = array( "id" => $id );
   		$result = $this->global_model->update_data( $this->table, $where, array('del_status' => 1 ) );
   		if( $result){
   			$res = array('status' => true, 'msg' => "account delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}
   	
   	//CUSTOMER ACCOUNTS
   	public function customeraccounts(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			$data['account_listing'] = $this->global_model->getdata("ac_customer_accounts", array( 'del_status' => 0), "", "id" );
   			//$data['account_listing'] = $this->accounts_model->get_all_customer_accounts();
   			//echo $this->db->last_query(); die;   			
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/customer_accounts_listing', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("dashboard");
   		}
   	}
   	
   	
   	//add/update customer account details
   	public function add_cus_account( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		$data['lid'] = $id;
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			$data['pending_accounts'] = $this->accounts_model->check_pending_customers_accounts();
   			if( $id ){
   				$data['account_listing'] = $this->global_model->getdata("ac_customer_accounts", array( 'id' => $id, 'del_status' => 0) );
   				$data['booking_listing'] = $this->global_model->getdata("ac_booking_reference_details", array( 'cus_account_id' => $id ));
   			}   			
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/add_customer_account', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("dashboard");
   		}
   	}
   	
   	//ajax_add_customer_account_details
   	public function ajax_add_customer_account_details(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93') && isset( $_POST['customer_name'] )  ){
   			$customer_name 		= $this->input->post('customer_name');
   			$customer_email 	= $this->input->post('customer_email');
   			$customer_contact 	= $this->input->post('customer_contact');
   			$alternate_contact_number = $this->input->post('alternate_contact_number');
   			$address	 	= $this->input->post('address');
   			$remarks	 	= $this->input->post('remarks');
   			$id	 			= $this->input->post('id');
   			$state_id	 	= $this->input->post('state_id');
   			$country_id	 	= $this->input->post('country_id');
   			$place_of_supply_state_id	= $this->input->post('place_of_supply_state_id');
   			$client_gst	= $this->input->post('client_gst');
   			$status	 	= isset( $_POST['status'] ) ? 1 : 0 ;
   			
   			//check if account_name exists
   			$check_account_email = $this->accounts_model->is_account_name_exists( "ac_customer_accounts", "customer_email", $customer_email, $id );
   			$check_account_contact = $this->accounts_model->is_account_name_exists( "ac_customer_accounts", "customer_contact", $customer_email, $id );
   			
   			if( $check_account_email ){
   				$res = array('status' => false, 'msg' => "Customer email already exists! You can add iti id against this email id by edit customer.");
   				die( json_encode($res) );
   			}
   			
   			if( $check_account_contact ){
   				$res = array('status' => false, 'msg' => "Customer Contact Number already exists! You can add iti id against this Contact Number by edit customer.");
   				die( json_encode($res) );
   			}
   			
   			//insert data
   			$data = array(
   				'customer_name' => $customer_name,
   				'customer_email' => $customer_email,
   				'customer_contact' => $customer_contact,
   				'alternate_contact_number' => $alternate_contact_number,
   				'status' => $status,
   				'address' => $address,
   				'country_id' => $country_id,
   				'state_id' => $state_id,
   				'remarks' => $remarks,
   				'updated_by' => $user_id,
   				'place_of_supply_state_id' => $place_of_supply_state_id,
   				'client_gst' => $client_gst,
   			);
   			
   			if( $id ){
   				//check if new iti id request
   				if( isset( $_POST['new_iti_id'] ) && !empty( $_POST['new_iti_id'] ) ){
   					$new_iti_id = $_POST['new_iti_id'];
   					$new_cus_id = $_POST['new_cus_id'];
   					//insert iti id to booking table
   					$this->global_model->insert_data("ac_booking_reference_details", array("cus_account_id" => $id, "lead_id" => $new_cus_id, "iti_id" => $new_iti_id ) );
   				}
   				
   				$this->global_model->update_data("ac_customer_accounts", array("id" => $id ), $data );
   				$res = array('status' => true, 'msg' => "Account updated successfully!", "id" => $id );	
   				
   			}else{
   				
   				$iti_id	 	  = $this->input->post('iti_id');
   				$customer_id  = $this->input->post('customer_id');
   				if( empty( $iti_id ) || empty( $customer_id ) ){
   					$res = array('status' => false, 'msg' => "Iti Id is required!");
   					die( json_encode($res) );
   				}
   				
   				$last_in_id = $this->global_model->insert_data("ac_customer_accounts", $data );
   				//insert iti id to booking table
   				$this->global_model->insert_data("ac_booking_reference_details", array("cus_account_id" => $last_in_id, "lead_id" => $customer_id, "iti_id" => $iti_id ) );
   				
   				$res = array('status' => true, 'msg' => "Account created successfully!", "id" => $last_in_id );	
   			}
   			
   		}else{
   			$res = array('status' => false, 'msg' => "Invalid Action. Try again");
   		}
   		
   		die( json_encode($res) );
   		
   	}
   	
   	
   	//view customer account details
   	public function view_customer( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93' ) && !empty($id) ) {
   			$data['account_listing'] = $this->global_model->getdata("ac_customer_accounts", array( 'id' => $id, 'del_status' => 0) );
   			$data['booking_listing'] = $this->global_model->getdata("ac_booking_reference_details", array( 'cus_account_id' => $id ));
   			$data['invoices_listing'] = $this->global_model->getdata( "ac_receipts", array( 'customer_acc_id' => $id, 'del_status' => 0 ) );
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/view_customer_account', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	//delete customer account iti
   	public function delete_cus_account(){
   		$id = $this->input->get('id');
   		$where = array( "id" => $id );
   		$result = $this->global_model->update_data( "ac_customer_accounts", $where, array('del_status' => 1 ) );
   		if( $result){
   			$res = array('status' => true, 'msg' => "account delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}
   	
   	
   	/********************************
   	********* RECEIPTS ****************
   	********************************/
   	//BANK RECEIPTS listing
   	public function receipts(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			$data['invoices_listing'] = $this->accounts_model->get_all_receipts("bank");
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/receipts/index', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	
   	//CASH RECEIPT
   	public function cash_receipts(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			$data['invoices_listing'] = $this->accounts_model->get_all_receipts("cash");
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/receipts/index_cash_receipts', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	//create_ Receipt
   	public function create_receipt( $lead_id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( $user['role'] == '99' || $user['role'] == '93' ) {
   			//if lead id exists check customer account
   			$data['get_customer_account'] = array();
   			if( $lead_id ){
   				$data['get_customer_account'] = get_customer_account( $lead_id );
   				if( empty( $data['get_customer_account']  ) ){
   					$this->session->set_flashdata('error',"Customer account does not exists. Please create new account");
   					redirect("accounts/add_cus_account/{$lead_id}");
   					exit;
   				}
   			}
   			
   			$data['customer_accounts'] = $this->accounts_model->get_customer_accounts();
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/receipts/create_receipt', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	//get cash/bank account
   	public function get_cash_bank_accounts(){
   		if( isset( $_POST['receipt_type'] ) &&   !empty($_POST['receipt_type']) ){
   			$get_ac_list = $this->global_model->getdata("ac_bank_cash_account_listing", array( "del_status" => 0, "account_type" => trim( $_POST['receipt_type'] ) ) );
   			
   			if( $get_ac_list ){
   				echo "<option>Select Account</option>";
   				foreach( $get_ac_list as $list ){
   					echo "<option value='{$list->id}'>{$list->account_name}</option>";
   				}
   			}else{
   				echo "<option>No Data found</option>";
   			}
   		}else{
   			echo "<option>No Data found</option>";
   		}
   		exit;
   	}
   	
   	//ajax_add_invoice_details
   	public function ajax_add_receipt_details(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ( $user['role'] == '99' || $user['role'] == '93' ) && isset( $_POST["amount_received"] ) && !empty( $_POST['customer_acc_id'] ) ) {
   			$customer_acc_id 		= $this->input->post('customer_acc_id');
   			$lead_id 		= $this->input->post('customer_id');
   			$receipt_type 	= $this->input->post('receipt_type');
   			$account_type_id = $this->input->post('account_type_id');
   			$voucher_date	 = $this->input->post('voucher_date');
   			$transfer_type	 = $this->input->post('transfer_type');
   			$transfer_ref	 = $this->input->post('transfer_ref');
   			$transfer_date	 = $this->input->post('transfer_date');
   			$narration	 	= $this->input->post('narration');
   			$amount_received	= $this->input->post('amount_received');
   			
   			//check if transfer_ref exists
   			if( $receipt_type == "bank" ){
   				$check_transfer_ref = $this->global_model->getdata("ac_receipts", array("transfer_ref" => trim( $transfer_ref ) ) );
   				if( $check_transfer_ref ){
   					$res = array('status' => false, 'msg' => "Transfer reference already exists.");
   					die( json_encode($res) );
   				}
   			}	
   			
   			//check if amount is empty
   			if( empty( $amount_received ) || $amount_received < 0 ){
   				$res = array( 'status' => false, 'msg' => "Please enter valid amount." );
   				die( json_encode($res) );
   			}
   			
   			$voucher_date = change_date_format_dmy_to_ymd( $voucher_date );
   			$transfer_date = change_date_format_dmy_to_ymd( $transfer_date );
   			
   			//insert data
   			$data = array(
   				"customer_acc_id" => $customer_acc_id,
   				"receipt_type" => $receipt_type,
   				"account_type_id" => $account_type_id,
   				"voucher_date" => $voucher_date,
   				"lead_id" => $lead_id,
   				"transfer_type" => $transfer_type,
   				"transfer_ref" => $transfer_ref,
   				"transfer_date" => $transfer_date,
   				"narration" => $narration,
   				"amount_received" => $amount_received,
   				"agent_id" => $user_id,
   			);
   			
   			$insert_invoice = $this->global_model->insert_data("ac_receipts", $data);

			//delete pending payement notifications
			$whereD = array( "notification_type" => 4 , "customer_id" => $id);   		
			$delete_notification = $this->global_model->delete_data("notifications", $whereD);
   			
   			//UPDATE voucher number
   			$voucher_number = $receipt_type == "bank" ? "BR-{$insert_invoice}" : "CR-{$insert_invoice}";
   			$this->global_model->update_data("ac_receipts", array("id" => $insert_invoice), array("voucher_number" => $voucher_number ) );
   			
   			if($insert_invoice){
   				$res = array( 'status' => true, 'msg' => "Receipt generate successfully.", 'id' => $insert_invoice );
   			}else{
   				$res = array( 'status' => true, 'msg' => "Receipt Not Generated." );
   			}
   		}else{
   			$res = array( 'status' => false, 'msg' => "Something went wrong. Invalid action." );
   		}
   		die( json_encode($res) );
   	}
   	
   	//update invoices
   	public function update_receipt($id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93' ) && !empty($id) ) {
   			$data['invoice'] = $this->global_model->getdata("ac_receipts", array( 'id' => $id, 'del_status' => 0) );
   			
   			//$data['account_listing'] = $this->global_model->getdata("ac_customer_accounts", array( 'id' => $id, 'del_status' => 0) );
   			//$data['booking_listing'] = $this->global_model->getdata("ac_booking_reference_details", array( 'cus_account_id' => $id ));
   			
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/receipts/update_receipt', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("accounts/receipts");
   		}
   	}
   	
   	//ajax_update_invoice_details
   	public function ajax_update_receipt_details(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ( $user['role'] == '99' || $user['role'] == '93' ) && isset( $_POST["amount_received"] ) && !empty( $_POST['id'] ) ) {
   			$voucher_date	 = $this->input->post('voucher_date');
   			$transfer_type	 = $this->input->post('transfer_type');
   			$transfer_ref	 = $this->input->post('transfer_ref');
   			$transfer_date	 = $this->input->post('transfer_date');
   			$amount_received	= $this->input->post('amount_received');
   			$narration	 		= $this->input->post('narration');
   			$id	 				= $this->input->post('id');
   			
   			
   			//check if transfer_ref exists
   			$check_transfer_ref = $this->global_model->getdata("ac_receipts", array("transfer_ref" => trim( $transfer_ref ), "id !=" => $id ) );
   			if( $check_transfer_ref ){
   				$res = array('status' => false, 'msg' => "Transfer reference already exists.");
   				die( json_encode($res) );
   			}
   			
   			//check if amount is empty
   			if( empty( $amount_received ) || $amount_received < 0 ){
   				$res = array( 'status' => false, 'msg' => "Please enter valid amount." );
   				die( json_encode($res) );
   			}
   			
   			$voucher_date = change_date_format_dmy_to_ymd( $voucher_date );
   			$transfer_date = change_date_format_dmy_to_ymd( $transfer_date );
   			
   			//insert data
   			$data = array(
   				"voucher_date" => $voucher_date,
   				"transfer_type" => $transfer_type,
   				"transfer_ref" => $transfer_ref,
   				"transfer_date" => $transfer_date,
   				"narration" => $narration,
   				"amount_received" => $amount_received,
   				"agent_id" => $user_id,
   			);
   			
   			$update = $this->global_model->update_data("ac_receipts", array("id" => $id), $data);
   			if( $update ){
   				$res = array( 'status' => true, 'msg' => "Receipt generate successfully." );
   			}else{
   				$res = array( 'status' => false, 'msg' => "Receipt not updated." );
   			}
   		}else{
   			$res = array( 'status' => false, 'msg' => "Something went wrong. Invalid action." );
   		}
   		die( json_encode($res) );
   	}
   	
   	//view invoice
   	public function view_receipt( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93' ) && !empty($id) ) {
   			$data['invoice'] = $this->global_model->getdata("ac_receipts", array( 'id' => $id, 'del_status' => 0) );
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/receipts/view_receipt', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("accounts/receipts");
   		}
   	}
   	
   	//delete delete_invoice
   	public function delete_invoice(){
   		$id = $this->input->get('id');
   		$where = array( "id" => $id );
   		$result = $this->global_model->update_data( "ac_receipts", $where, array('del_status' => 1 ) );
   		if( $result){
   			$res = array('status' => true, 'msg' => "Receipt delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}
   	
   	
   	//Send invoice
   	public function ajax_send_receipt(){
   		$user = $this->session->userdata('logged_in');
		//    var_dump($user);die;
   		$user_id = $user['user_id'];
   		if( ( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '93' ) && isset( $_POST['lead_id'] ) ){
   			$id 	= $this->input->post("id", true);
   			$lead_id = $this->input->post("lead_id", true);
   			$customer_email = $this->input->post("customer_email", true);
   			$subject = strip_tags( $this->input->post("subject", true) );
   			
   			
   			//get receipt
   			$where = array( "id" => $id );
   			$get_receipt = $this->global_model->getdata( "ac_receipts", $where );
   			
   			//get customer account info
   			$get_cus_info 	= get_customer_account( $lead_id );
   			$customer_name 	= isset( $get_cus_info[0]->customer_name ) ? $get_cus_info[0]->customer_name : "";
   			$customer_email = isset( $get_cus_info[0]->customer_email ) ? $get_cus_info[0]->customer_email : $customer_email;
   			$customer_contact = isset( $get_cus_info[0]->customer_contact ) ? $get_cus_info[0]->customer_contact : "";
   			
   			/* Check if hotel Email is empty */
   			if( empty( $customer_email ) ){
   				$res = array('status' => false, 'msg' => "Email Id Does Not Exists Or Invalid.");
   				die( json_encode($res) );
   			}
   			
   			//client view
   			$vid			 	= base64_url_encode( $get_receipt[0]->id );
   			$voucher_number 	= base64_url_encode( $get_receipt[0]->voucher_number );
   			$receipt_link = "<a title='View Receipt' href=" . site_url("promotion/receipt/{$vid}/{$voucher_number}") . " class='btn btn-danger' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i> Click here to view receipt</a>";
   			
   			$message = "HI, <strong> {$customer_name} </strong> <br><br>";
   			$message .= "Click below link to view receipt<br><br>";
   			$message .= "{$receipt_link} <br><br>";
   			$message .= " Thanks. <trackitinerary.com>";
   			
   			//Get admin emails
   			$from = get_accounts_team_email();
   			
   			//Check if BCC and CC Email exists
   			$bcc_emails 		= $this->input->post("bcc_email", true);
   			$cc_email 			= $this->input->post("cc_email", true);
   			$bccEmails 			= !empty($bcc_emails) ? $bcc_emails : "";
   			$ccEmails 			= !empty($cc_email) ? $cc_email : "";
   			
   			//send mail to customer
   			$sent_mail = sendEmail( $customer_email, $subject, $message, $bccEmails, $ccEmails  );
   			
   			if( $sent_mail ){
   				//check if is_lead_approved_by_account_team
   				$get_iti_data = $this->global_model->getdata("iti_payment_details", array("customer_id" => $lead_id ) );
   				
   				//if lead not verified
   				if( isset($get_iti_data[0]) && $get_iti_data[0]->approved_by_account_team == 0 ){
   					//get iti data
   					if( !isset( $get_iti_data[0]->iti_id ) ){
   						$res = array('status' => false, 'msg' => "Invalid request.");
   						die( json_encode($res) );
   					}
   					
   					$iti_id = $get_iti_data[0]->iti_id;
   					$temp_key = $get_iti_data[0]->temp_key;
   					$agent_id = $get_iti_data[0]->agent_id;
   					
   					//update data
   					$up_data = array(
   						"approved_by_account_team" 	=> 1,
   					);
   
   					$update_data = $this->global_model->update_data("iti_payment_details", array("customer_id" => $lead_id ), $up_data );
   					if( $update_data ){
   						/************************
   						***** EMAIL SECTION *****
   						/************************/
   						//sent mail to client and agent tmp
   						//$manager_email 	= manager_email();
   						$hotel_booking_email = hotel_booking_email();				
   						$admins 		= array( $hotel_booking_email );				
   						$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";							
   						$sub 			= "New Itinerary Booked <trackitinerary.org>";
   						$msg 			= "Itinerary Booked <br>";				
   						$msg 			.= "Itinerary Id: {$iti_id} <br>";				
   						$msg 			.= "Lead Id: {$lead_id} <br>";				
   						$msg 			.= "{$link}<br>";
   						
   						//send mail to manager and admin
   						$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
   						
   						
   						/************************
   						** NOTIFICATION SECTION **
   						/************************/
   						
   						$where_notif = "notification_type IN (2,3) AND customer_id = {$lead_id}";
   						$this->global_model->delete_data_custom("notifications", $where_notif );
   						
   						//Create notification if next call time exists
   						$agent_name = get_user_name( $agent_id );
   						$title 		= "New Iti Booked";
   						$c_date 	= current_datetime();
   						$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
   						$body 		= "New Itinerary Booked By {$agent_name}";
   						$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
   						
   						$notification_datan = array(
   							array(
   								"customer_id"		=> $lead_id,
   								"notification_for"	=> 97, //97 = service team
   								"title"				=> $title,
   								"body"				=> $body,
   								"url"				=> $notif_link,
   								"notification_time"	=> $notif_time,
   								"agent_id"			=> $agent_id,
   							) 
   						);
   						
   						//Insert notification
   						$this->global_model->insert_batch_data( "notifications", $notification_datan );
   					}
   				}
   				
   				//update count
   				$count_email = $get_receipt[0]->sent_count;
   				if( empty( $count_email ) ){
   					$count_email = 0;
   				}
   				$email_inc = $count_email+1;
   				$up_data = array(
   					'sent_count' => $email_inc,
   				);
   				
   				$where_hotel_booking = array( "id" => $id );
   				$this->global_model->update_data( "ac_receipts", array( "id" => $id ), $up_data );
   				
   				$res = array('status' => true, 'msg' => "Receipt Sent Successfully!");
   			}else{
   				$res = array('status' => false, 'msg' => "Mail Not Sent. Please Try Again Later.");
   			}
   			die( json_encode($res) );
   		}else{
   			redirect(404);
   		}
   	}
   	
   	//delete delete_booking_account_lead
   	public function delete_booking_account_lead(){
   		$id = $this->input->get('id');
   		$where = array( "lead_id" => $id );
   		$result = $this->global_model->delete_data( "ac_booking_reference_details", $where );
   		if( $result){
   			$res = array('status' => true, 'msg' => "booking delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}
   	
   	
   	/**********************/
   	/*****INVOICES*********/
   	/**********************/
   	
   	//GET ALL INVOICES
   	public function invoices(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];
   		
   		if( ($user['role'] == '99' || $user['role'] == '98' || $user['role'] == '93') ) {
   			$data['invoices'] = $this->global_model->getdata( "ac_invoices" , '', '', 'id');
   			
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/invoices/index', $data);
   			$this->load->view('inc/footer'); 
   			
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	//generate invoice
   	public function generate_invoice( $lead_id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ( $user['role'] == '99' || $user['role'] == '93' ) && $lead_id  ) {
   			$iti_payment_details = $this->global_model->getdata( "iti_payment_details", array( "customer_id" => $lead_id, "iti_close_status" => 1 ) );
   			$check_invoice = $this->global_model->getdata( "ac_invoices", array( "lead_id" => $lead_id ) );
   			$get_checkout_date = $this->global_model->getdata( "itinerary", array( "customer_id" => $lead_id, 'iti_status' => 9 ) );
   			
   			//if payments not exists
   			if( empty( $iti_payment_details ) || empty( $get_checkout_date ) ){
   				redirect(404);
   				exit;
   			} 
   			
   			//if invoice exists
   			if( $check_invoice ){
   				$id = $check_invoice[0]->id;
   				redirect("accounts/view_invoice/{$id}");
   				exit;
   			}
   			
   			//if lead id exists check customer account
   			$data['get_customer_account'] = get_customer_account( $lead_id );
   			if( empty( $data['get_customer_account']  ) ){
   				$this->session->set_flashdata('error',"Customer account does not exists. Please create new account");
   				redirect("accounts/add_cus_account/{$lead_id}");
   				exit;
   			}
   			
   			//get checkout date
   			$checkout	=  !empty( $get_checkout_date[0]->t_end_date ) ? change_date_format_dmy_to_ymd( $get_checkout_date[0]->t_end_date ) : date('Y-m-d');
   			$month = date("m", strtotime( $checkout ));
   			$checkout_year = date("Y", strtotime( $checkout ));
   			
   			//year last two digit
   			$checkout_year_s = date("y", strtotime( $checkout ));
   			$next_year_s		= $checkout_year_s + 1;
   			
   			//next year
   			$next_year			= $checkout_year + 1;
   			$prev_year 			= $checkout_year - 1;
   			
   			if( ( $month >= 4 ) ){
   				$f_year = $checkout_year . "-" . $next_year_s; 
   				$ff_year = $checkout_year . "-" . $next_year; 
   			}else{
   				$f_year = $prev_year . "-" . $checkout_year_s; 
   				$ff_year = $prev_year . "-" . $checkout_year; 
   			}
   			
   			//check invoice_no
   			$check_invoice = $this->global_model->getdata('ac_invoices', array( 'financial_year' => $ff_year ), 'invoice_no', 'id' );
   			if( isset( $check_invoice ) && !empty( $check_invoice )){
   				$tmp_invoice = explode("/" , $check_invoice);
   				$last_invoice =  end ( $tmp_invoice ); 
   				$inv_id = $last_invoice+1;
   				$inv_number =  sprintf("%'04d", $inv_id);
   			}else{
   				$inv_number = "0001";
   			}
   			$invoice_no = "SY/{$f_year}/{$inv_number}";
   			
   			$booking_id =  isset( $iti_payment_details[0]->booking_id ) ? $iti_payment_details[0]->booking_id : "";
   			//insert data
   			$ins_data = array(
   				'financial_year' 	=> $ff_year,
   				"lead_id" 			=> $lead_id, 
   				"agent_id" 			=> $user_id,
   				"invoice_no" 		=> $invoice_no,
   				"booking_id" 		=> $booking_id,
   			);
   			
   			$insert_invoice = $this->global_model->insert_data("ac_invoices", $ins_data );
   			
   			//UPDATE voucher number
   			//$this->global_model->update_data("ac_invoices", array("id" => $insert_invoice), array( "invoice_no" => $invoice_no ) );
   			redirect("accounts/view_invoice/{$insert_invoice}");
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	//view_invoice
   	public function view_invoice( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];
   		
   		if( ($user['role'] == '99' || $user['role'] == '98' || $user['role'] == '93') && ( $id ) ) {
   			//if lead id exists check customer account
   			$data['invoice']	 			= $this->global_model->getdata( "ac_invoices", array( "id" => $id ) );
   			$lead_id = isset( $data['invoice'][0] ) ? $data['invoice'][0]->lead_id : 0;
   			$data['iti_payment_details'] 	= $this->global_model->getdata( "iti_payment_details", array( "customer_id" => $lead_id ) );
   			$data['itinerary'] 				= $this->global_model->getdata( "itinerary", array( "customer_id" => $lead_id ) );
   			$data['customer']				= $this->global_model->getdata( "customers_inquery", array( "customer_id" => $lead_id ) );
   			
   			$this->load->view('accounts/invoices/view_invoice', $data);
   			
   		}else{
   			redirect("accounts");
   		}
   	}
   	
   	//PENDING INVOICES
   	public function pending_invoices(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93 ){
   			//check pending invoices
   			$sql = "SELECT i.*, c.customer_name, c.customer_contact,c.customer_contact FROM itinerary as i LEFT JOIN ac_invoices as inv on ( i.customer_id = inv.lead_id) INNER JOIN customers_inquery as c ON ( i.customer_id = c.customer_id ) WHERE i.iti_close_status = 1 AND i.del_status = 0 AND i.iti_status = 9 AND inv.id is NULL group by i.iti_id";
   			$q = $this->db->query($sql);
   			$data['pending_invoices'] = $q->result();
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/invoices/pending_invoices', $data);
   			$this->load->view('inc/footer'); 
   		}else{
   			redirect(404);
   		}	
   	}
   	
   	//delete link
   	public function delete_invoice_perm(){
   		$id = $this->input->get('id');
   		$where = array( "id" => $id );
   		$result = $this->global_model->delete_data( "ac_invoices", $where );
   		if( $result){
   			$res = array('status' => true, 'msg' => "Invoice delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}
   	
   	
   	/********************************
   	******ONLINE PAYMENTS SECTION****
   	********************************/
   	public function all_online_transactions(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93 ){
   			//check all transactions
   			$data['get_all_transactions'] = $this->global_model->getdata('ac_online_transactions', '', '', 'id');
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/payments/admin/all_transcations', $data);
   			$this->load->view('inc/footer'); 
   		}else{
   			redirect(404);
   		}	
   	}	
   	
   	//ajax get transactions
   	public function ajax_all_online_transactions(){
   		$user = $this->session->userdata('logged_in');
   		//Sort Variables
   		$table = "ac_online_transactions";
   		$column_order = array(null, 'order_id'); 
   		$column_search = array("order_id","customer_id", "iti_id", 'customer_email', 'customer_contact', 'trans_id');
   		$order = array('id' => 'DESC'); // default order 
   		$where = array();
   		
   		//Get filter Data
   		if( isset( $_POST['date_from'])  && isset( $_POST['date_to'] ) && !empty($_POST['date_from']) ){
   			//if city_id not exists
   			$where["trans_date >="] = date('Y-m-d', strtotime($_POST['date_from']));
   			$where["trans_date <="] = date('Y-m-d H:i:s', strtotime($_POST['date_to'] . "23:59:59"));
   		}
   		
   		//check if filter exsits
   		if( isset( $_POST['filter'] ) && !empty( $_POST['filter'] ) ){
   			if( $_POST['filter'] == 1 ){
   				$where['t_response_code'] = 1; 
   			}else if( $_POST['filter'] == "fail" ){
   				$where['t_response_code !='] = 1;
   			}
   		}
   		
   		$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
   		$data = array();
   		$no = $_POST['start'];
   		if( !empty($list) ){
   			foreach ($list as $transaction){
   				$tra_s = $transaction->trans_status == "TXN_SUCCESS" ? "<strong class='green'>SUCCESS</strong>" : "<strong class='red'>FAIL</strong>";
   				$no++;
   				$row = array();
   				$row[] = $no;
   				$row[] = $transaction->order_id;
   				$row[] = $transaction->customer_id;
   				$row[] = $transaction->customer_name;
   				$row[] = $transaction->customer_contact;
   				$row[] = $transaction->customer_email;
   				$row[] = $transaction->trans_id;
   				$row[] = $transaction->trans_amount;
   				$row[] = $tra_s;
   				$row[] = $transaction->trans_date;
   				
   				$btn = "<a href=" . site_url("accounts/view_pay/{$transaction->id}") . " class='btn btn-success' target='_blank' title='View Payement' ><i class='fa fa-eye'></i></a>";
   				
   				$row[] = $btn;
   				$data[] = $row;
   			}
   		}	
   		
   		$output = array(
   			"draw" => $_POST['draw'],
   			"recordsTotal" => $this->global_model->count_all_data($table, $where),
   			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
   			"data" => $data,
   		);
   		//output to json format
   		echo json_encode($output);
   	}
   	
   	//view transactions
   	public function view_pay($id = NULL){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( ($user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93) && $id ){
   			$data['view_transactions'] = $this->global_model->getdata('ac_online_transactions', array('id' => $id ));
   			//dump($data['view_transactions']); die;
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/payments/admin/view_transcations', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect(404);
   		}
   	}
   	
   	//generate payment link
   	public function create_payment_link( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93 ){
   			
   			if( $id ){
   				$data['payment_link'] = $this->global_model->getdata('ac_payment_links', array( 'id' => $id, 'status' => 0 ) );
   				if( isset( $data['payment_link'][0]->paid_status) &&   $data['payment_link'][0]->paid_status == 1 ) {
   					echo "You can't edit this order because its already paid. Please contact your adminstrator.";
   					exit;
   				}
   			}	
   			//check all transactions
   			$data['get_all_booked_iti'] = $this->accounts_model->check_booked_iti();
   			
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/payments/admin/generate_payment_link', $data );
   			$this->load->view('inc/footer'); 
   		}else{
   			redirect(404);
   		}	
   	}
   	
   	//update link
   	public function ajax_generate_payment_link(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( ($user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93) && isset( $_POST['customer_id'] ) && !empty( $_POST['amount'] ) ){
   			$customer_id = $this->input->post('customer_id', TRUE);
   			$amount = $this->input->post('amount', TRUE);
   			$id 	= $this->input->post('id', TRUE);
   			$link_expire_date 	= $this->input->post('link_expire_date', TRUE);
   			
   			$check_valid_customer = $this->global_model->getdata('iti_payment_details', array( 'customer_id' => $customer_id ));
   			if( isset($check_valid_customer[0]->iti_id ) ){
   				$iti_id = $check_valid_customer[0]->iti_id;
   				$link_token 	= "PM" . rand(1000,9999) . time();
   				
   				//update id
   				if( $id ){
   					$data = array(
   						'customer_id' => $customer_id,
   						'iti_id' => $iti_id,
   						'link_expire_date' => $link_expire_date,
   						'trans_amount' => $amount
   					);
   					
   					$ins = $this->global_model->update_data('ac_payment_links', array('id' => $id ) , $data);
   					$r_id = $id;
   				}else{
   					$data = array(
   						'link_token' => $link_token,
   						'customer_id' => $customer_id,
   						'iti_id' => $iti_id,
   						'link_expire_date' => $link_expire_date,
   						'trans_amount' => $amount,
   						'agent_id' => $user_id,
   					);
   					$ins = $this->global_model->insert_data('ac_payment_links', $data);
   					$r_id = $ins;
   				}
   				
   				if( $ins ){
   					$res = array('status' => true, 'msg' => "Payment link successfully created.", 'id' => $r_id );
   				}else{
   					$res = array('status' => false, 'msg' => "Payment link not update. Please try again.");
   				}
   				
   			}else{
   				$res = array('status' => false, 'msg' => "Invalid Action. Try again");
   			}
   			
   		}else{
   			$res = array('status' => false, 'msg' => "Invalid Action. Try again");
   		}	
   		die( json_encode($res) );
   	}
   
   	//all payment links
   	public function payment_links(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( ($user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93) ){
   			$data['payment_links'] = $this->global_model->getdata('ac_payment_links', array('status' => 0), '','id');
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/payments/admin/all_payment_links', $data );
   			$this->load->view('inc/footer'); 
   		}else{
   			redirect(404);
   		}	
   	}	
   	//view
   	public function view_payment_link($id=null){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( ($user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93) && !empty( $id ) ){
   			$data['payment_link'] = $this->global_model->getdata('ac_payment_links', array('id' => $id));
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('accounts/payments/admin/view_payment_link', $data );
   			$this->load->view('inc/footer'); 
   		}else{
   			redirect(404);
   		}	
   	}
   	
   	//delete link
   	public function delete_paylink(){
   		$id = $this->input->get('id');
   		$where = array( "id" => $id );
   		$result = $this->global_model->update_data( "ac_payment_links", $where, array('status' => 1 ) );
   		if( $result){
   			$res = array('status' => true, 'msg' => "Payment link delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}
   	
   	//CHECK STATUS
   	public function check_payment_status(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user["user_id"];
   		$data['user_role'] 	= $user['role'];
   		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93 || $user['role'] == 96 ){
   			$this->load->library('Paytm');
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view("accounts/payments/admin/pgStatus");
   			$this->load->view('inc/footer'); 
   		}else{
   			redirect(404);
   		}	
   	}
   }	
   ?>