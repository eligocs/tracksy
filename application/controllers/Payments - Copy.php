<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Payments extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("payments_model");
	}
	
	//Show all Itinerary payments details
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('payments/itinerary/all_payments');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	//Update payment details
	public function update_payment(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$id = trim($this->uri->segment(3));
		$iti_id = trim($this->uri->segment(4));
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$data["payment"] = $this->global_model->getdata("iti_payment_details", array("id" => $id, "iti_id" => $iti_id) );
			$data["payment_transaction"] = $this->global_model->getdata("iti_payment_transactions", array("iti_id" => $iti_id) );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('payments/itinerary/update', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	//View Payments Detail single
	public function view(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$id = trim($this->uri->segment(3));
		$iti_id = trim($this->uri->segment(4));
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$data["payment"]			 = $this->global_model->getdata("iti_payment_details", array("id" => $id, "iti_id" => $iti_id) );
			$data["payment_transaction"] = $this->global_model->getdata("iti_payment_transactions", array("iti_id" => $iti_id) );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('payments/itinerary/view', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	/* data table get all Payments */
	public function ajax_payments_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '97' ){
			$where = array();
			$list = $this->payments_model->get_datatables($where);
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $payment) {
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				$balance = $payment->total_balance_amount;
				$row = array();
				$row[] = $no;
				$row[] = $payment->iti_id;
				$row[] = $payment->customer_name;
				$row[] = $payment->customer_contact;
				$row[] = number_format ($payment->total_package_cost )." /-";
				$row[] = !empty( $balance ) ? number_format( $balance ) . " /-" : "Nil";
				$row[] = $payment->next_payment_due_date;
				$row[] = empty( $balance) ? "<strong class='btn btn-success'>Done</strong>" : "<strong class='btn btn-danger'>Processing</strong>";
				
				//buttons
				$update_btn = "<a title='Update Payments Detail' href=" . site_url("payments/update_payment/{$payment->id}/{$payment->iti_id}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				//$btn_view = "<a title='View' href=" . site_url("payments/view/{$payment->id}/{$payment->iti_id}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				$row[] = $update_btn;
				
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->payments_model->count_all($where),
			"recordsFiltered" => $this->payments_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	//ajax request to update Itinerary Payment Details
	public function updatePaymentDetails(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		/* Add Payment Details */
		if( isset( $_POST["iti_id"] ) && !empty( $_POST["total_payment_recieve"] ) ){
			$ins_number			= trim($this->input->post("ins_number", TRUE));
			$tra_id 			= strip_tags($this->input->post("tra_id", TRUE));
			$iti_id 			= strip_tags($this->input->post("iti_id", TRUE));
			$pay_type 			= strip_tags($this->input->post("pay_type", TRUE));
			$bank_name 			= strip_tags($this->input->post("bank_name", TRUE));
			$next_payment_bal 	= strip_tags($this->input->post("next_payment_bal", TRUE));
			$next_payment_date 	= strip_tags($this->input->post("next_payment_date", TRUE));
			$payment_recieve	= strip_tags($this->input->post("payment_recieve", TRUE));
			$last_balance		= strip_tags($this->input->post("last_balance", TRUE));
			$new_due_balance	= strip_tags($this->input->post("new_due_balance", TRUE));
			
			if( empty( $payment_recieve ) &&  empty( $iti_id ) ){
				$res = array('status' => false, 'msg' => "All Fields are required!");
				die( json_encode($res) );
			}elseif( trim($last_balance) < trim( $payment_recieve ) || !is_numeric( $payment_recieve ) ){
				$res = array('status' => false, 'msg' => "Please Enter Valid Amount!");
				die( json_encode($res) );
			}
			
			
			$res = array('status' => false, 'msg' => "Payment not update please reload page and try again!");
			die( json_encode($res) );
			
			
			
			$nxtPay = !empty( $new_due_balance ) ? $next_payment_date : "";
			//update payment details
			$up_data = array(
				"next_payment"					=> $next_payment_bal,
				"next_payment_due_date"			=> $nxtPay,
				"last_payment_received_date"	=> current_datetime(),
				"total_balance_amount"			=> $new_due_balance,
			);
			$where = array( "id" => $tra_id, "iti_id" => $iti_id );
			$update_data = $this->global_model->update_data("iti_payment_details", $where, $up_data );
			if( !$update_data ){
				$res = array('status' => false, 'msg' => "Payment not update please reload page and try again!");
				die( json_encode($res) );
			}
			
			//Insert Payment data to transaction table
			$in_data = array(
				"iti_id"				=> $iti_id,
				"payment_received"		=> $payment_recieve,
				"payment_type"			=> $pay_type,
				"bank_name"				=> $bank_name,
				"agent_id"				=> $u_id,
			);
			$insert_data = $this->global_model->insert_data("iti_payment_transactions", $in_data );
			if( $insert_data ){
				$res = array('status' => true, 'msg' => "Payment Update Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Payment Not Update Successfully!");
			}
		}else{
			$res = array('status' => false, 'msg' => "Payment Not Update! Please reload page and try again");
		}	
		die( json_encode($res) );
	}	
	
	//ajax request to update Itinerary Close Status
	public function updateCloseStatus(){
		$iti_id = $_POST["iti_id"];
		$cus_id = $_POST["cus_id"];
		if( trim( $iti_id ) && trim( $cus_id ) ){
			$data = array( "iti_close_status" => 1 );
			//update itinerary status
			$update_iti = $this->global_model->update_data("itinerary", array( "iti_id" => $iti_id ) , $data );
			$update_iti_pay = $this->global_model->update_data("iti_payment_details", array( "iti_id" => $iti_id ) , $data );
			//update customer close status
			$up_cus_status = $this->global_model->update_data("customers_inquery", array( "customer_id" => $cus_id ) , array("lead_close_status" => 1) );
			
			if( $update_iti &&  $up_cus_status && $update_iti_pay ){
				$res = array('status' => true, 'msg' => "Itinerary Status Update!");
			}else{
				$res = array('status' => false, 'msg' => "Itinerary Status Not Update Successfully!");
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid Request Try Again!");
		}
		die( json_encode($res) );
	}
	
	//Accommodation Details
	//Show all Accommodation payments details
	public function accommodation(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('payments/accommodation/all_acc_payments');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	/* data table get all Acc Payments */
	public function ajax_acc_payments_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$list = "";
		
		//Sort Variables
		$table = "acc_payment_details";
		$column_order = array(null, 'acc_id'); 
		$column_search = array('acc_id');
		$order = array('id' => 'DESC'); // default order 
		$where = array();
		
		if( $role == '99' || $role == '98' || $role == '97' ){
			$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $payment) {
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				$balance = $payment->total_balance_amount;
				$row = array();
				$row[] = $no;
				$row[] = $payment->acc_id;
				$row[] = $payment->customer_name;
				$row[] = $payment->customer_contact;
				$row[] = number_format ($payment->total_package_cost )." /-";
				$row[] = !empty( $balance ) ? number_format( $balance ) . " /-" : "Nil";
				$row[] = $payment->next_payment_due_date;
				$row[] = empty( $balance) ? "<strong class='btn btn-success'>Done</strong>" : "<strong class='btn btn-danger'>Processing</strong>";
				
				//buttons
				$update_btn = "<a title='Update Payments Detail' href=" . site_url("payments/accommodation_update_payment/{$payment->id}/{$payment->acc_id}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				$row[] = $update_btn;
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
	
	//Update payment details
	public function accommodation_update_payment(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$id = trim($this->uri->segment(3));
		$acc_id = trim($this->uri->segment(4));
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$data["payment"] = $this->global_model->getdata("acc_payment_details", array("id" => $id, "acc_id" => $acc_id) );
			$data["payment_transaction"] = $this->global_model->getdata("acc_payment_transactions", array("acc_id" => $acc_id) );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('payments/accommodation/update_acc_pay', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	//ajax request to update Payment Details
	public function updateAccommodationPaymentDetails(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		/* Add Payment Details */
		$tra_id 			= strip_tags($this->input->post("tra_id", TRUE));
		$acc_id 			= strip_tags($this->input->post("acc_id", TRUE));
		$pay_type 			= strip_tags($this->input->post("pay_type", TRUE));
		$bank_name 			= strip_tags($this->input->post("bank_name", TRUE));
		$next_payment_bal 	= strip_tags($this->input->post("next_payment_bal", TRUE));
		$next_payment_date 	= strip_tags($this->input->post("next_payment_date", TRUE));
		$payment_recieve	= strip_tags($this->input->post("payment_recieve", TRUE));
		$last_balance		= strip_tags($this->input->post("last_balance", TRUE));
		$new_due_balance	= strip_tags($this->input->post("new_due_balance", TRUE));
		
		if( empty( $payment_recieve ) &&  empty( $acc_id ) ){
			$res = array('status' => false, 'msg' => "All Fields are required!");
			die( json_encode($res) );
		}elseif( trim($last_balance) < trim( $payment_recieve ) || !is_numeric( $payment_recieve ) ){
			$res = array('status' => false, 'msg' => "Please Enter Valid Amount!");
			die( json_encode($res) );
		}
		
		$nxtPay = !empty( $new_due_balance ) ? $next_payment_date : "";
		
		//update payment details
		$up_data = array(
			"next_payment"			=> $next_payment_bal,
			"next_payment_due_date"	=> $nxtPay,
			"total_balance_amount"	=> $new_due_balance,
		);
		$where = array( "id" => $tra_id, "acc_id" => $acc_id );
		$update_data = $this->global_model->update_data("acc_payment_details", $where, $up_data );
		if( !$update_data ){
			$res = array('status' => false, 'msg' => "Payment not update please reload page and try again!");
			die( json_encode($res) );
		}
		
		//Insert Payment data to transaction table
		$in_data = array(
			"acc_id"				=> $acc_id,
			"payment_received"		=> $payment_recieve,
			"payment_type"			=> $pay_type,
			"bank_name"				=> $bank_name,
			"agent_id"				=> $u_id,
		);
		$insert_data = $this->global_model->insert_data("acc_payment_transactions", $in_data );
		if( $insert_data ){
			$res = array('status' => true, 'msg' => "Payment Update Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Payment Not Update Successfully!");
		}
		die( json_encode($res) );
	}	
	
	//ajax request to update Accommodation Close Status
	public function updateAccommodationCloseStatus(){
		$acc_id = $_POST["acc_id"];
		$cus_id = $_POST["cus_id"];
		if( trim( $acc_id ) && trim( $cus_id ) ){
			$data = array( "acc_close_status" => 1 );
			//update Accommodation status
			$update_iti = $this->global_model->update_data("accommodation", array( "acc_id" => $acc_id ) , $data );
			$update_iti_pay = $this->global_model->update_data("acc_payment_details", array( "acc_id" => $acc_id ) , $data );
			//update customer close status
			$up_cus_status = $this->global_model->update_data("customers_inquery", array( "customer_id" => $cus_id ) , array("lead_close_status" => 1) );
			
			if( $update_iti &&  $up_cus_status && $update_iti_pay ){
				$res = array('status' => true, 'msg' => "Accommodation Status Update!");
			}else{
				$res = array('status' => false, 'msg' => "Accommodation Status Not Update Successfully!");
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid Request Try Again!");
		}
		die( json_encode($res) );
	}
	
}	
?>