<?php defined('BASEPATH') OR exit('No direct script access allowed');
   class Ledger extends CI_Controller {
   	public $table = "ac_vendor_accounts";
   	public function __Construct(){
   	   	parent::__Construct();
   		validate_login();
   		$this->load->model("ledger_model");		
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
   			$this->load->view('ledger/vender_accounts_listing', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("dashboard");
   		}
   	}
   	
   	//add account details
   	public function add_vendor_account( $id = NULL ){
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
   			$this->load->view('ledger/add_vender_account', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("dashboard");
   		}
   	}
	
   	//ajax_add_vendor_account_details
   	public function ajax_add_vendor_account_details(){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93') && isset( $_POST['name'] )  ){
   			$name 		= $this->input->post('name');
   			$email 		= $this->input->post('email');
   			$contact 	= $this->input->post('contact');
   			$alternate_contact_number = $this->input->post('alternate_contact_number');
   			$address	 	= $this->input->post('address');
   			$remarks	 	= $this->input->post('remarks');
   			$id	 			= $this->input->post('id');
			
   			//insert data
   			$data = array(
   				'name' => $name,
   				'email' => $email,
   				'contact' => $contact,
   				'alternate_contact_number' => $alternate_contact_number,   				
   				'address' => $address,   				
   				'remarks' => $remarks,
   				'updated_by' => $user_id,   				   				
   			);
   			
   			if( $id ){   				
   				$this->global_model->update_data("ac_vendor_accounts", array("id" => $id ), $data );
   				$res = array('status' => true, 'msg' => "Account updated successfully!", "id" => $id );	
   			}else{
   				$last_in_id = $this->global_model->insert_data("ac_vendor_accounts", $data );
   				$res = array('status' => true, 'msg' => "Account created successfully!", "id" => $last_in_id );	
   			}
   		}else{
   			$res = array('status' => false, 'msg' => "Invalid Action. Try again");
   		}
   		die( json_encode($res) );   		
   	}
   	
   	
   	//view customer account details
   	public function view_vendor( $id = NULL ){
   		$user = $this->session->userdata('logged_in');
   		$user_id = $user['user_id'];
   		$data['user_id'] = $user_id;
   		$data['user_role'] = $user['role'];		
   		if( ($user['role'] == '99' || $user['role'] == '93' ) && !empty($id) ) {
   			$data['account_listing'] = $this->global_model->getdata("ac_vendor_accounts", array( 'id' => $id, 'del_status' => 0) );   			
   			//$data['invoices_listing'] = $this->global_model->getdata( "ac_receipts", array( 'customer_acc_id' => $id, 'del_status' => 0 ) );
   			$this->load->view('inc/header');
   			$this->load->view('inc/sidebar');
   			$this->load->view('ledger/view_vendor_account', $data);
   			$this->load->view('inc/footer');
   		}else{
   			redirect("ledger");
   		}
   	}
   	
   	//delete customer account iti
   	public function delete_vendor_account(){
   		$id = $this->input->get('id');
   		$where = array( "id" => $id );
   		$result = $this->global_model->update_data( "ac_vendor_accounts", $where, array('del_status' => 1 ) );
   		if( $result){
   			$res = array('status' => true, 'msg' => "account delete Successfully!");
   		}else{
   			$res = array('status' => false, 'msg' => "Error! please try again later");
   		}
   		die(json_encode($res));
   	}   
} ?>