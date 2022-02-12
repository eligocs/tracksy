<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Payments extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("payments_model");
		$this->load->model("itinerary_model");
		$this->load->helper('email');
		$this->load->helper('path');
	}
	
	//Show all Itinerary payments details
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '97' || $user['role'] == '93' ){
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
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '97' || $user['role'] == '93' ){
			$data["payment"] = $this->global_model->getdata("iti_payment_details", array("id" => $id, "iti_id" => $iti_id) );
			$data["payment_transaction"] = $this->global_model->getdata("iti_payment_transactions", array("iti_id" => $iti_id) );
			$data["refund_transaction"] = $this->global_model->getdata("payment_refund", array("iti_id" => $iti_id) );
			
			$data["receipts"] = $this->global_model->getdata("ac_receipts", array("lead_id" => $data["payment"][0]->customer_id, "del_status" => 0 ) );
			
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
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '97' || $user['role'] == '93' ){
			$data["payment"]			 = $this->global_model->getdata("iti_payment_details", array("id" => $id, "iti_id" => $iti_id) );
			$data["payment_transaction"] = $this->global_model->getdata("iti_payment_transactions", array("iti_id" => $iti_id) );
			$data["refund_transaction"] = $this->global_model->getdata("payment_refund", array("iti_id" => $iti_id) );
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
		
		if( $role == '99' || is_super_manager() || $role == '97' || $user['role'] == '93' ){
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
				//Check for refund
				
				//Get itinerary type 1=itinerary , 2=accommodation
				$iti_type = $payment->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";
				
				$refund_exist = !empty( $payment->refund_amount ) && ($payment->refund_status == "unpaid") ? "<span class='red'>Refund Pending</span>" : "";
				$refunded = !empty( $payment->refund_amount ) && $payment->refund_status == "paid" ? "<span class='green'>Refunded</span>" : "";
				
				//check iti close status
				if( $payment->iti_close_status == 1 ){
					$st = "<strong class='btn btn-danger'>Closed</strong>";
				}else if( is_empty( $balance ) && empty($refund_exist) ){
					$st = "<strong class='btn btn-success'>Done</strong>";
				}else{
					$st = "<strong class='btn btn-default'>Processing</strong>";
				} 
				
				$row = array();
				$row[] = $no;
				$row[] = $payment->iti_id;
				$row[] = $iti_type;
				$row[] = $payment->customer_name;
				$row[] = $payment->customer_contact;
				$row[] = number_format ($payment->total_package_cost )." /-";
				$row[] = !empty( $balance ) ? number_format( $balance ) . " /-" : "Nil";
				$row[] = $payment->next_payment_due_date;
				$row[] = $st;
				
				//buttons
				$update_btn = "<a title='Update Payments Detail' href=" . site_url("payments/update_payment/{$payment->id}/{$payment->iti_id}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				//$btn_view = "<a title='View' href=" . site_url("payments/view/{$payment->id}/{$payment->iti_id}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				$row[] = $update_btn . $refund_exist . $refunded;
				
				//payment status
				$row[] = $payment->payement_confirmed_status == 0 ? "<label class='mt-checkbox'> <input type='checkbox' title='Checked if package cost confirmed' value='0' data-id ={$payment->id} class='form-control is_payment_confirmed' ><span></span></label> <i class='fa fa-spinner fa-spin' aria-hidden='true'></i>" : "<span class='btn btn-success' title='Payment Confirmed'><i title='Processing' class='fa fa-check' aria-hidden='true'></i> Confirmed</span>";
				
				
				$row[] = $payment->travel_date;
				
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
		$today = date("Y-m-d");
		/* Add Payment Details */
		if( isset( $_POST["iti_id"] ) && ( !empty( $_POST["total_payment_recieve"] ) || isset( $_POST['discount'] ) ) ){
			$ins_number			= trim($this->input->post("ins_number", TRUE));
			$tra_id 			= strip_tags($this->input->post("tra_id", TRUE));
			$iti_id 			= strip_tags($this->input->post("iti_id", TRUE));
			$customer_id 		= strip_tags($this->input->post("customer_id", TRUE));
			$pay_type 			= strip_tags($this->input->post("pay_type", TRUE));
			$bank_name 			= strip_tags($this->input->post("bank_name", TRUE));
			$next_payment_bal 	= strip_tags($this->input->post("next_payment_bal", TRUE));
			$next_payment_date 	= strip_tags($this->input->post("next_payment_date", TRUE));
			$payment_recieve	= strip_tags($this->input->post("total_payment_recieve", TRUE));
			$last_balance		= strip_tags($this->input->post("last_balance", TRUE));
			$new_due_balance	= strip_tags($this->input->post("new_due_balance", TRUE));
			$invoice_date		= isset( $_POST['invoice_date'] ) ? $_POST['invoice_date'] : date("Y-m-d");
			//$travel_date		= strip_tags($this->input->post("travel_date", TRUE));
			
			$discount	= strip_tags($this->input->post("discount", TRUE));
			$total_discount = !empty( $discount ) ? $discount : 0;
			
			if( empty( $iti_id ) ){
				$res = array('status' => false, 'msg' => "All Fields are required!");
				die( json_encode($res) );
			}
			
			/* if( empty( $payment_recieve ) &&  empty( $iti_id ) ){
				$res = array('status' => false, 'msg' => "All Fields are required!");
				die( json_encode($res) );
			}elseif( trim($last_balance) < trim( $payment_recieve ) || !is_numeric( $payment_recieve ) ){
				$res = array('status' => false, 'msg' => "Please Enter Valid Amount!");
				die( json_encode($res) );
			} */
			
			//Check For Balance amount
			$checkBal = !empty( $new_due_balance ) ? $new_due_balance : 0;
			
			//Define variables
			$next_payment_date_notify = "";
			$nextPay = $nextPayDate	= $thirdPay = $thirdDate = $finalPay = $finalDate = $tPaid = $fPaid = $sPaid = "";
			
			//Check for third and final amount
			$third_inst = isset( $_POST['third_payment_bal'] ) 	? trim( $_POST['third_payment_bal'] ) : "";
			$third_date = isset( $_POST['third_payment_date'] ) && !empty( $third_inst ) ? $_POST['third_payment_date'] : "";
			$tPaid 		= !empty( $third_inst ) ? "unpaid" : "";
			$final_inst = isset( $_POST['final_payment_bal'] ) 	? trim( $_POST['final_payment_bal'] ) : "";
			$final_date = isset( $_POST['final_payment_date'] ) && !empty( $final_inst ) ? $_POST['final_payment_date'] : "";
			$fPaid 		= !empty( $final_inst ) ? "unpaid" : "";
			$updateData = array();
			//Check installment number
			switch( $ins_number ){
				case 1:
					//Case 1 for Received 2nd installment
					//check if balance pending
					if( !empty( $checkBal ) ){
						$nextPay	 	= $third_inst;
						$nextPayDate 	= $third_date;
						$finalPay 		= $final_inst;
						$finalDate 		= $final_date;
					}
					//next date for notificaiton
					$next_payment_date_notify	= $third_date;
					
					//update payment details
					$updateData = array(
						'next_payment'					=> $nextPay,
						'next_payment_due_date'			=> $nextPayDate,
						'second_payment_bal'			=> $payment_recieve,
						'second_payment_date'			=> $today,
						'third_payment_bal'				=> $nextPay,
						'third_payment_date'			=> $nextPayDate,
						'final_payment_bal'				=> $finalPay,
						'final_payment_date'			=> $finalDate,
						'last_payment_received_date'	=> current_datetime(),
						'total_balance_amount'			=> $new_due_balance,
						'second_pay_status'				=> 'paid',
						'third_pay_status'				=> $tPaid,
						'final_pay_status'				=> $fPaid,
					);
				break;
				case 2:
					//Case 2 for Received third installment	
					//check if balance pending
					if( !empty( $checkBal ) ){
						$nextPay	 	= $final_inst;
						$nextPayDate 	= $final_date;
					}
					//next date for notificaiton
					$next_payment_date_notify	= $final_date;
					
					//update payment details
					$updateData = array(
						'next_payment'					=> $nextPay,
						'next_payment_due_date'			=> $nextPayDate,
						'third_payment_bal'				=> $payment_recieve,
						'third_payment_date'			=> $today,
						'final_payment_bal'				=> $nextPay,
						'final_payment_date'			=> $nextPayDate,
						'last_payment_received_date'	=> current_datetime(),
						'total_balance_amount'			=> $new_due_balance,
						'third_pay_status'				=> "paid",
						'final_pay_status'				=> $fPaid,
					);
				break;
				case 3:
					//Case 3 for Received Final Installment
					if( $checkBal > 0 || !empty( $checkBal ) ){
						$res = array('status' => "invalid", 'msg' => "Payment Not Update.Please Make sure you are receiving all amount because this is last Installment!");
						die( json_encode($res) );
					}
					
					//update payment details
					$updateData = array(
						'next_payment'					=> "",
						'next_payment_due_date'			=> "",
						'final_payment_bal'				=> $payment_recieve,
						'final_payment_date'			=> $today,
						'last_payment_received_date'	=> current_datetime(),
						'total_balance_amount'			=> $new_due_balance,
						'final_pay_status'				=> "paid",
					);
				break;
				default:
					continue2;
				break;
			}
			
			//add data 
			//$updateData['travel_date'] = $travel_date;
			
			//$nxtPay = !empty( $new_due_balance ) ? $next_payment_date : "";
			/* $updateData = array(
				"next_payment"					=> $next_payment_bal,
				"next_payment_due_date"			=> $nxtPay,
				"last_payment_received_date"	=> current_datetime(),
				"total_balance_amount"			=> $new_due_balance,
			); */
			
			$where = array( "id" => $tra_id, "iti_id" => $iti_id );
			$update_data = $this->global_model->update_data("iti_payment_details", $where, $updateData );
			
			if( !$update_data ){
				$res = array('status' => "invalid", 'msg' => "Payment not update please reload page and try again!");
				die( json_encode($res) );
			}
			
			//update discount need to add this with updateData array
			$update_discount = $this->payments_model->update_discount("iti_payment_details", $where, $total_discount );
			
			//Insert Payment data to transaction table
			$in_data = array(
				"iti_id"				=> $iti_id,
				"payment_received"		=> $payment_recieve,
				"payment_type"			=> $pay_type,
				"bank_name"				=> $bank_name,
				"agent_id"				=> $u_id,
				"invoice_date"			=> $invoice_date,
			);
			
			/*
			* NOTIFICATION SECTION 
			*/
			
			//Delete last notification for customer if/any
			//notification_type = 4 for payment
			$where_notif 		= array( "notification_type" => 4, "customer_id" => $customer_id );
			$this->global_model->delete_data("notifications", $where_notif);
			
			//Create notification if next call time exists
			if( !empty( $next_payment_date_notify ) ){
				$title 		= "Payment Pending";
				$c_date 	= date("Y-m-d", strtotime($next_payment_date_notify ));
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " 11:15:00") );
				$body 		= "Payment Pending Of Itinerary.";
				$notif_link = "payments/update_payment/{$tra_id}/{$iti_id}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 93, //97 = service team
					"notification_type"	=> 4, //4 = payment pending
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $u_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
			}
			
			/**
			* END NOTIFICATION SECTION
			**/
			
			$insert_data = $this->global_model->insert_data("iti_payment_transactions", $in_data );
			if( $insert_data ){
				$res = array('status' => true, 'msg' => "Payment Update Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Payment Not Update.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Payment Not Update! Please reload page and try again");
		}	
		die( json_encode($res) );
	}	
	
	//Postpone payment dates
	public function postpone_payment_dates(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$today = date("Y-m-d");
		/* Add Payment Details */
		if( isset( $_POST["iti_id"] ) && !empty( $_POST["iti_id"] ) && $user ){
			$iti_id 		= trim($this->input->post("iti_id", TRUE));
			$customer_id 	= trim($this->input->post("customer_id", TRUE));
			$ins_number		= trim($this->input->post("ins_number", TRUE));
			$tra_id			= trim($this->input->post("tra_id", TRUE));
			$second_date 	= isset( $_POST['second_payment_date'] ) ? $_POST['second_payment_date'] : "";
			$third_date 	= isset( $_POST['third_payment_date'] ) ? $_POST['third_payment_date'] : "";
			$final_date 	= isset( $_POST['final_payment_date'] ) ? $_POST['final_payment_date'] : "";
			
			$next_payment_date_notify = "";
			//If dates not exists
			/* if( empty($second_date) && empty($third_date) && empty($final_date) ){
				$res = array('status' => false, 'msg' => "$second_date Dates Not $third_date Postpone Please $final_date validate all fields and try again!");
				die( json_encode($res) );
			} */
			
			$updateData = array();
			//Check installment
			switch( $ins_number ){
				case 1:
					$updateData = array(
						"next_payment_due_date" => $second_date,
						"second_payment_date" => $second_date,
						"third_payment_date" => $third_date,
						"final_payment_date" => $final_date,
					);
					
					//for notificaiton
					$next_payment_date_notify = $second_date;
					//Second installment not exists
					if( empty( $second_date ) ){
						$res = array('status' => false, 'msg' => "Invalid Request!");
						die( json_encode($res) );
					}
					
				break;
				case 2:
					$updateData = array(
						"next_payment_due_date" => $third_date,
						"third_payment_date" => $third_date,
						"final_payment_date" => $final_date,
					);
					
					//for notificaiton
					$next_payment_date_notify = $third_date;
					
					//Third installment not exists
					if( empty( $third_date ) ){
						$res = array('status' => false, 'msg' => "Invalid Request!");
						die( json_encode($res) );
					}
				break;
				case 3:
					$updateData = array(
						"next_payment_due_date" => $final_date,
						"final_payment_date" => $final_date,
					);
					
					//for notificaiton
					$next_payment_date_notify = $final_date;
					
					//Final installment not exists
					if( empty( $final_date ) ){
						$res = array('status' => false, 'msg' => "Invalid Request!");
						die( json_encode($res) );
					}
				break;
				default: 
					continue2;
				break;
			}
			
			$where = array( "id" => $tra_id, "iti_id" => $iti_id );
			$update_data = $this->global_model->update_data("iti_payment_details", $where, $updateData );
			
			if( $update_data ){
				/*
				* NOTIFICATION SECTION 
				*/
				
				//Delete last notification for customer if/any
				//notification_type = 4 for payment
				$where_notif 		= array( "notification_type" => 4, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				if( !empty( $next_payment_date_notify ) ){
					$title 		= "Payment Pending";
					$c_date 	= date("Y-m-d", strtotime($next_payment_date_notify ));
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " 11:15:00") );
					$body 		= "Payment Pending Of Itinerary.";
					$notif_link = "payments/update_payment/{$tra_id}/{$iti_id}";
					
					//if less then 50% payment received send notification to agent
					/* $total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti_id );
					if( $total_payment_recieved_percentage < 50 ){
						$temp_key = get_iti_temp_key($iti_id);
						$notif_link_ag = "itineraries/view/{$iti_id}/{$temp_key}";
						$agent_notify = array(
							"customer_id"		=> $customer_id,
							"notification_for"	=> 96, //96 = sales team
							"notification_type"	=> 4, //4 = payment pending
							"title"				=> $title,
							"body"				=> $body,
							"url"				=> $notif_link_ag,
							"notification_time"	=> $notif_time,
							"agent_id"			=> $u_id
						);
						//Insert notification
						$this->global_model->insert_data( "notifications", $agent_notify );
					} */
					
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 93, //97 = accounts team
						"notification_type"	=> 4, //4 = payment pending
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $u_id,
					);
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
				}
				
				/**
				* END NOTIFICATION SECTION
				**/
			
				$res = array('status' => true, 'msg' => "Payment Dates Postpone Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Dates not Postpone please reload page and try again!");
			}
		}else{
			$res = array('status' => "false", 'msg' => "Please try again!");
		}
		die( json_encode($res) );
	}
	
	//ajax request to update Itinerary Close Status
	public function updateCloseStatus(){
		if( isset( $_POST["iti_id"] ) && !empty( $_POST["id"] ) && !empty( $_POST["total_package_cost"] ) ){
			//$package_actual_cost = $_POST["package_actual_cost"];
			$iti_id 			= $_POST["iti_id"];
			$customer_id 		= $_POST["customer_id"];
			$total_package_cost = $_POST["total_package_cost"];
			$customer_name 		= $_POST["customer_name"];
			
			$data = array( "iti_close_status" => 1, "final_amount" => $total_package_cost );
			$pay_data = array(
				"iti_close_status" => 1 ,
				"next_payment" => 0,
				"next_payment_due_date" => "",
				"refund_status" => "paid",
				"second_pay_status" => "paid",
				"third_pay_status" => "paid",
				"final_pay_status" => "paid",
				"total_balance_amount" => 0,
				"total_package_cost" => $total_package_cost,
				//"package_actual_cost" => $package_actual_cost,
				"customer_name"	 => $customer_name,
			);
			
			//update itinerary status
			$update_iti = $this->global_model->update_data("itinerary", array( "iti_id" => $iti_id ) , $data );
			$update_iti_pay = $this->global_model->update_data("iti_payment_details", array( "iti_id" => $iti_id ) , $pay_data );
			
			//update customer close status
			$up_cus_status = $this->global_model->update_data("customers_inquery", array( "customer_id" => $customer_id ) , array("lead_close_status" => 1, "customer_name" => $customer_name) );
			
			//update customer close status
			$up_cus_status_invoice = $this->global_model->update_data("ac_booking_reference_details", array( "lead_id" => $customer_id ) , array("close_account" => 1 ) );
			
			
			
			//Deleter all notifications AND OLD Itineraries of customer
			$where_notif = array( "customer_id" => $customer_id );
			$this->global_model->delete_data("notifications", $where_notif);
			
			//del old iti
			$this->global_model->delete_data("iti_before_amendment", array("iti_id" => $iti_id ) );
			$this->global_model->delete_data("iti_amendment_temp", array("iti_id" => $iti_id ) );
			
			
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
	
	//ajax request to update Amendment Payment Details
	public function amendment_payment_details(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		/* Add Payment Details */
		if( isset( $_POST["iti_id"] ) && !empty( $_POST["iti_id"] ) ){
			$ins_number				= trim($this->input->post("ins_number", TRUE));
			$id						= trim($this->input->post("id", TRUE));
			$iti_id 				= strip_tags($this->input->post("iti_id", TRUE));
			$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
			$amendment_payment_bal 	= strip_tags($this->input->post("amendment_payment_bal", TRUE));
			$installment_date 		= strip_tags($this->input->post("installment_date", TRUE));
			$new_due_balance		= strip_tags($this->input->post("total_balance_amount", TRUE));
			$amendment_note			= strip_tags($this->input->post("amendment_note", TRUE));
			$total_package_cost		= strip_tags($this->input->post("total_package_cost", TRUE));
			$checkBal				= !empty( $new_due_balance ) ? $new_due_balance : 0;
			$travel_date			= strip_tags($this->input->post("travel_date", TRUE));
			$amendment_id			= strip_tags($this->input->post("amendment_id", TRUE));
			$is_gst					= 1;
			
			//check if amendment note or id
			if( empty( $ins_number ) &&  empty( $amendment_note ) ){
				$res = array('status' => false, 'msg' => "All Fields are required!");
				die( json_encode($res) );
			}
			
			$updateData = array();
			//Check installment number 1 = second_ins , 2=third ins , 3= final_ins
			switch( $ins_number ){
				case 1:
					//update payment details
					$updateData = array(
						"second_payment_bal"			=> $amendment_payment_bal,
						"second_payment_date"			=> $installment_date,
						"second_pay_status"				=> "unpaid",
					);
				break;
				case 2:
					//update payment details
					$updateData = array(
						"third_payment_bal"				=> $amendment_payment_bal,
						"third_payment_date"			=> $installment_date,
						"third_pay_status"				=> "unpaid",
					);
				break;
				case 3:
					//Case 3 for Received Final Installment
					$updateData = array(
						"final_payment_bal"				=> $amendment_payment_bal,
						"final_payment_date"			=> $installment_date,
						"final_pay_status"				=> "unpaid",
					);
				break;
				default:
					continue2;
				break;
			}
			
			//add next_payment to array
			$updateData["next_payment"]		 		= $amendment_payment_bal;
			$updateData["next_payment_due_date"] 	= $installment_date;
			$updateData["total_balance_amount"] 	= $checkBal;
			$updateData["total_package_cost"] 		= $total_package_cost;
			$updateData["package_actual_cost"] 		= $total_package_cost;
			$updateData["is_gst"] 					= $is_gst;
			$updateData["amendment_note"] 			= $amendment_note;
			$updateData["travel_date"] 				= $travel_date;
			
			$where = array( "id" => $id, "iti_id" => $iti_id );
			$update_data = $this->global_model->update_data("iti_payment_details", $where, $updateData );
			
			if( $update_data ){
				//Update old itinerary
				$update_old_iti = $this->itinerary_model->update_old_itinerary("iti_amendment_temp", "id", $amendment_id );
				
				//Update amendment_temp table
				$u_d = array( "sent_for_review" => 3, "review_update_date" => current_datetime() );
				$update_amendment = $this->global_model->update_data("iti_amendment_temp", array("id" => $amendment_id ), $u_d );
				
				//delete other amendment iti 
				$delete = $this->payments_model->delete_amendment( $amendment_id, $iti_id );
				
				//Update hotel booking status on iti_vouchers_status table if exists
				$ck_iti_in_voucher = $this->global_model->count_all("iti_vouchers_status", array( "iti_id" => $iti_id ));
				if( $ck_iti_in_voucher ){
					$update_booking_status = array("hotel_booking_status" => 0 ,"vtf_booking_status" => 0, "cab_booking_status" => 0, "confirm_voucher" => 0 );
					$this->global_model->update_data( "iti_vouchers_status", array("iti_id" => $iti_id ), $update_booking_status );
				}
				//sent mail to admin/manager/customer
				//get customer info 
				$get_customer_info = get_customer( $customer_id ); 
				$pay_pending = "";
				if( $checkBal ){
					$pay_pending = "Final Amount: {$total_package_cost} and next Installment Date is {$installment_date}";
				}
				
				$cust = $get_customer_info[0];
				$customer_name		= !empty($get_customer_info) ? $cust->customer_name : "";
				$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact: "";
				$customer_email		= !empty($get_customer_info) ? $cust->customer_email : "";
				$temp_key			= get_iti_temp_key( $iti_id );
				
				$admin_email 	= admin_email();
				$manager_email 	= manager_email();
				$service_email 	= hotel_booking_email();
				$admins 		= array( $admin_email, $manager_email, $service_email, "accounts1@Trackitinerary.in" );
				$to				= $customer_email;
				
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view Revised itinerary</a>";
				$linkClientView = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check Revised itinerary</a>";
				
				$sub 			= "Itinerary Revised Successfully and price updated. <Trackitinerary.org>";
				$msg 			= "Itinerary Revised <br>";
				$msg 			.= "Final Amount: {$total_package_cost} <br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "Customer Name: {$customer_name} <br>";
				$msg 			.= "{$link}<br>";
				
				//Customer message
				$msg_c 			= "Itinerary Revised <br>";
				$msg_c 			.= "Final Amount: {$total_package_cost} <br>";
				$msg_c 			.= "Itinerary Id: {$iti_id} <br>";
				$msg_c 			.= " {$pay_pending} <br>";
				$msg_c 			.= "{$linkClientView}<br>";
				
				//send mail to customer
				$sent_mail	 = sendEmail($to, $sub, $msg_c);
				//send mail to manager and admin
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				//send msg for customer on Itinerary revised 
				$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
				
				
				$mobile_customer_sms = "Your itinerary is revised. {$pay_pending} For more info contact us. Please review Revised Itinerary {$iti_link}. Thanks<Trackitinerary>";
				
				if( !empty( $customer_contact ) ){
					$sendcustomer_sms = pm_send_sms( $customer_contact, $mobile_customer_sms );
				} 
				
				
				
				/*
				* NOTIFICATION SECTION 
				*/
				//Delete last notification for customer if/any
				//notification_type = 2 for iti followup and 3 = price request
				$where_notif 		= array( "notification_type !=" => 0, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$temp_key	= get_iti_temp_key( $iti_id );
				$agent_name = get_user_name( $user_id );
				$title 		= "Revised Itinerary Approved";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
				$body 		= "Revised Itinerary Approved By {$agent_name}";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 98, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"agent_id"			=> $user_id,
						"notification_time"	=> $notif_time,
					),	
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 97, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $user_id,
					)
				);
				
				//Insert notification
				$this->global_model->insert_batch_data( "notifications", $notification_data );
				
				//next payment details
				if( !empty( $installment_date  ) ){
					$title 		= "Payment Pending";
					$c_date 	= date("Y-m-d", strtotime($installment_date ));
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " 11:15:00") );
					$body 		= "Payment Pending Of Itinerary.";
					$notif_link = "payments/update_payment/{$id}/{$iti_id}";
					
					//if less then 50% payment received send notification to agent
					/* $total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti_id );
					if( $total_payment_recieved_percentage < 50 ){
						$notif_link_ag = "itineraries/view/{$iti_id}/{$temp_key}";
						$agent_notify = array(
							"customer_id"		=> $customer_id,
							"notification_for"	=> 96, //96 = sales team
							"notification_type"	=> 4, //4 = payment pending
							"title"				=> $title,
							"body"				=> $body,
							"url"				=> $notif_link_ag,
							"notification_time"	=> $notif_time,
							"agent_id"			=> $user_id
						);
						//Insert notification
						$this->global_model->insert_data( "notifications", $agent_notify );
					} */
					
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 93, //93 = accounts team
						"notification_type"	=> 4, //4 = payment pending
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $user_id,
					);
					
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
				}	
				
				/**
				* END NOTIFICATION SECTION
				**/
			
				$this->session->set_flashdata('success',"Amendment Updated Successfully.");
				$res = array('status' => true, 'msg' => "Payment update Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Payment Not Update.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Payment Not Update! Please reload page and try again");
		}	
		die( json_encode($res) );
	}	
	
	//ajax request to update price if client reduce package cost
	public function ajax_reduce_payment_installements(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$refund_date = $ins_date = "";
		$updateData = array();
		/* Add Payment Details */
		if( isset( $_POST["iti_id"] ) && !empty( $_POST["iti_id"] ) ){
			$ins_number				= trim($this->input->post("ins_number", TRUE));
			$id						= trim($this->input->post("id", TRUE));
			$iti_id 				= strip_tags($this->input->post("iti_id", TRUE));
			$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
			$total_balance_amount 	= strip_tags($this->input->post("total_balance_amount", TRUE));
			$amendment_note			= strip_tags($this->input->post("amendment_note", TRUE));
			$total_package_cost		= strip_tags($this->input->post("total_package_cost", TRUE));
			$clear_unpaid			= strip_tags($this->input->post("clear_unpaid", TRUE));
			$refund_amount			= strip_tags($this->input->post("refund_amount", TRUE));
			$travel_date			= strip_tags($this->input->post("travel_date", TRUE));
			$amendment_id			= strip_tags($this->input->post("amendment_id", TRUE));
			$is_gst					= 1;
			
			$checkBal				= !empty( $total_balance_amount ) ? $total_balance_amount : 0;
			
			//check if amendment note or id
			if( empty( $iti_id ) &&  empty( $amendment_note ) ){
				$res = array('status' => false, 'msg' => "All Fields are required!");
				die( json_encode($res) );
			}
			//Get payment details
			$payment_details = $this->global_model->getdata("iti_payment_details", array( "id" => $id ));
			$payment = $payment_details[0];
			
			//Check paid/unpaid installment
			$second_ins_unpaid = !empty( $payment->second_payment_bal ) && ( $payment->second_pay_status == "unpaid" ) ? $payment->second_payment_bal : 0;
			$third_ins_unpaid = !empty( $payment->third_payment_bal ) && ($payment->third_pay_status == "unpaid") ? $payment->third_payment_bal : 0;
			$final_ins_unpaid = !empty( $payment->final_payment_bal ) && ($payment->final_pay_status == "unpaid") ? $payment->final_payment_bal : 0;	
			
			
			//Check installment number 1 = second_ins , 2=third ins , 3= final_ins
			if( $ins_number ){
				$ins_amount			= strip_tags($this->input->post("amendment_payment_bal", TRUE));
				$ins_date			= strip_tags($this->input->post("installment_date", TRUE));
				
				switch( $ins_number ){
					case 1:
						$updateData = array(
							"second_payment_bal"			=> $ins_amount,
							"second_payment_date"			=> $ins_date,
							"second_pay_status"				=> "unpaid",
							"third_payment_bal"				=> "",
							"third_payment_date"			=> "",
							"third_pay_status"				=> "",
						);
					break;
					case 2:
						$updateData = array(
							"third_payment_bal"				=> $ins_amount,
							"third_payment_date"			=> $ins_date,
							"third_pay_status"				=> "unpaid",
							"final_payment_bal"				=> "",
							"final_payment_date"			=> "",
							"final_pay_status"				=> "",
						);
					break;
					case 3:
						$updateData = array(
							"final_payment_bal"				=> $ins_amount,
							"final_payment_date"			=> $ins_date,
							"final_pay_status"				=> "unpaid",
						);
					break;
					default:
						continue2;
					break;
				}
				
				//update next payment
				$updateData["next_payment"]		 		= $ins_amount;
				$updateData["next_payment_due_date"] 	= $ins_date;
			}	
			
			//if clear_upaid clear all unpaid fields
			if( !empty($clear_unpaid) ){
				
				if( $second_ins_unpaid ){
					$updateData["second_payment_bal"]	= "";
					$updateData["second_payment_date"] 	= "";
					$updateData["second_pay_status"] 	= "";
				}
				
				if( $third_ins_unpaid ) {
					$updateData["third_payment_bal"]	= "";
					$updateData["third_payment_date"] 	= "";
					$updateData["third_pay_status"] 	= "";
				}
				
				if( $final_ins_unpaid ){
					$updateData["final_payment_bal"]	= "";
					$updateData["final_payment_date"] 	= "";
					$updateData["final_pay_status"] 	= "";
				}
				
				$updateData["next_payment"]		 		= "";
				$updateData["next_payment_due_date"] 	= "";
			}
			
			//if refund exists
			if( !empty( $refund_amount ) ){
				$refund_date = strip_tags($this->input->post("refund_due_date", TRUE));
				//add refund update data
				$updateData["refund_amount"]	= $refund_amount;
				$updateData["refund_due_date"] 	= $refund_date;
				$updateData["refund_status"] 	= "unpaid";
			}
			
			//update balance and total cost to array
			$updateData["total_balance_amount"] 	= $checkBal;
			$updateData["total_package_cost"] 		= $total_package_cost;
			$updateData["package_actual_cost"] 		= $total_package_cost;
			$updateData["travel_date"] 				= $travel_date;
			$updateData["amendment_note"] 			= $amendment_note;
			$updateData["is_gst"] 					= $is_gst;
			
			$where = array( "id" => $id, "iti_id" => $iti_id );
			$update_data = $this->global_model->update_data("iti_payment_details", $where, $updateData );
			
			if( $update_data ){
				//Update old itinerary
				$update_old_iti = $this->itinerary_model->update_old_itinerary("iti_amendment_temp", "id", $amendment_id );
				
				//Update amendment_temp table
				$u_d = array( "sent_for_review" => 3, "review_update_date" => current_datetime() );
				$update_amendment = $this->global_model->update_data("iti_amendment_temp", array("id" => $amendment_id ), $u_d );
				//delete other amendment iti 
				$delete = $this->payments_model->delete_amendment( $amendment_id, $iti_id );
				
				//Update hotel booking status on iti_vouchers_status table if exists
				$ck_iti_in_voucher = $this->global_model->count_all("iti_vouchers_status", array( "iti_id" => $iti_id ));
				if( $ck_iti_in_voucher ){
					$update_booking_status = array("hotel_booking_status" => 0 ,"vtf_booking_status" => 0, "cab_booking_status" => 0, "confirm_voucher" => 0 );
					$this->global_model->update_data( "iti_vouchers_status", array("iti_id" => $iti_id ), $update_booking_status );
				}
				
				//sent mail to admin/manager/customer
				//get customer info 
				$get_customer_info 	= get_customer( $customer_id ); 
				$cust 				= $get_customer_info[0];
				$customer_name		= !empty($get_customer_info) ? $cust->customer_name : "";
				$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact: "";
				$customer_email		= !empty($get_customer_info) ? $cust->customer_email : "";
				$temp_key			= get_iti_temp_key( $iti_id );
				
				$admin_email 	= admin_email();
				$manager_email 	= manager_email();
				$service_email 	= hotel_booking_email();
				$admins 		= array( $admin_email, $manager_email, $service_email, "accounts1@Trackitinerary.in" );
				$to				= $customer_email;
				
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view Revised itinerary</a>";
				$linkClientView = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check Revised itinerary</a>";
				
				//If refund amount exists
				$refund_msg = "";
				if( !empty( $refund_amount ) ){
					$refund_msg = "Rs. {$refund_amount} amount will be refunded on {$refund_date}.";
				}
				
				$sub 			= "Itinerary Revised Successfully and price updated. <Trackitinerary.org>";
				
				$msg 			= "Itinerary Revised <br>";
				$msg 			.= "Final Amount: {$total_package_cost} <br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "Customer Name: {$customer_name} <br>";
				$msg 			.= " $refund_msg <br>";
				$msg 			.= "{$link}<br>";
				
				//Customer message
				$msg_c 			= "Itinerary Revised <br>";
				$msg_c 			.= "Final Amount: {$total_package_cost} <br>";
				$msg_c 			.= "Itinerary Id: {$iti_id} <br>";
				$msg_c 			.= "$refund_msg <br>";
				$msg_c 			.= "{$linkClientView}<br>";
				
				//send mail to customer
				$sent_mail	 = sendEmail($to, $sub, $msg_c);
				//send mail to manager and admin
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				//send msg for customer on Itinerary revised 
				$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
				$mobile_customer_sms = "Your itinerary is revised. {$refund_msg} For more info contact us. Please review Revised Itinerary {$iti_link}. Thanks<Trackitinerary>";
				
				if( !empty( $customer_contact ) ){
					$sendcustomer_sms = pm_send_sms( $customer_contact, $mobile_customer_sms );
				} 
				
				
				/*
				* NOTIFICATION SECTION 
				*/
				
				//Delete last notification for customer if/any
				//notification_type = 2 for iti followup and 3 = price request
				$where_notif 		= array( "notification_type !=" => 0, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$temp_key	= get_iti_temp_key( $iti_id );
				$agent_name = get_user_name( $u_id );
				$title 		= "Revised Itinerary Approved";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
				$body 		= "Revised Itinerary Approved By {$agent_name}";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 98, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"agent_id"			=> $u_id,
						"notification_time"	=> $notif_time,
					),	
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 97, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $u_id,
					)
				);
				//Insert notification
				$this->global_model->insert_batch_data( "notifications", $notification_data );
				
				//next payment details
				if( !empty( $ins_date  ) ){
					$title 		= "Payment Pending";
					$c_date 	= date("Y-m-d", strtotime($ins_date ));
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " 11:15:00") );
					$body 		= "Payment Pending Of Itinerary.";
					$notif_link = "payments/update_payment/{$id}/{$iti_id}";
					
					//if less then 50% payment received send notification to agent
					/* $total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti_id );
					if( $total_payment_recieved_percentage < 50 ){
						$notif_link_ag = "itineraries/view/{$iti_id}/{$temp_key}";
						$agent_notify = array(
							"customer_id"		=> $customer_id,
							"notification_for"	=> 96, //96 = sales team
							"notification_type"	=> 4, //4 = payment pending
							"title"				=> $title,
							"body"				=> $body,
							"url"				=> $notif_link_ag,
							"notification_time"	=> $notif_time,
							"agent_id"			=> $u_id
						);
						//Insert notification
						$this->global_model->insert_data( "notifications", $agent_notify );
					} */
					
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 93, //93 = accounts team
						"notification_type"	=> 4, //4 = payment pending
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $u_id,
					);
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
				}
				
				//if refund exists create notification
				if( !empty( $refund_date  ) ){
					$title 		= "Refund Payment";
					$c_date 	= date("Y-m-d", strtotime($refund_date ));
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " 11:15:00") );
					$body 		= "Refund Pending Of Itinerary.";
					$notif_link = "payments/update_payment/{$id}/{$iti_id}";
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 93, //93 = accounts team
						"notification_type"	=> 4, //4 = payment pending
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $u_id,
					);
					
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
				}
				
				/**
				* END NOTIFICATION SECTION
				**/
				
				$this->session->set_flashdata('success',"Amendment Updated Successfully.");
				$res = array('status' => true, 'msg' => "Payment update Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Payment Not Update.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Payment Not Update! Please reload page and try again");
		}	
		die( json_encode($res) );
	}
	
	//Refund to customer
	public function refund_amount_by_service_team(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$today = date("Y-m-d");
		/* Add Payment Details */
		if( isset( $_POST["iti_id"] ) && !empty( $_POST["refund_amount"] ) ){
			$tra_id 			= strip_tags($this->input->post("tra_id", TRUE));
			$iti_id 			= strip_tags($this->input->post("iti_id", TRUE));
			$customer_id 		= strip_tags($this->input->post("customer_id", TRUE));
			$refund_amount 		= strip_tags($this->input->post("refund_amount", TRUE));
			$bank_name 			= strip_tags($this->input->post("bank_name", TRUE));
			$pay_type 			= strip_tags($this->input->post("pay_type", TRUE));
			
			if( empty( $refund_amount ) &&  empty( $iti_id ) ){
				$res = array('status' => false, 'msg' => "Refund Amount should not be Zero!");
				die( json_encode($res) );
			}
			
			$updateData = array( "refund_status" => "paid" );
			
			$where = array( "id" => $tra_id, "iti_id" => $iti_id );
			$update_data = $this->global_model->update_data("iti_payment_details", $where, $updateData );
			
			if( !$update_data ){
				$res = array('status' => false, 'msg' => "Payment not update please reload page and try again!");
				die( json_encode($res) );
			}
			
			//Insert Payment data to refund transaction table
			$in_data = array(
				"iti_id"				=> $iti_id,
				"refund_amount"			=> $refund_amount,
				"payment_type"			=> $pay_type,
				"bank_name"				=> $bank_name,
				"agent_id"				=> $u_id,
			);
			
			$insert_data = $this->global_model->insert_data("payment_refund", $in_data );
			if( $insert_data ){
				
				//Delete last notification for customer if/any
				//notification_type = 4 for payment
				$where_notif 		= array( "notification_type !=" => 0, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				$res = array('status' => true, 'msg' => "Payment Refunded Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Payment Not Refunded Update.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Payment Not Update! Please reload page and try again");
		}	
		die( json_encode($res) );
	}
	//delete amendment
	public function delete_amendment(){
		$this->payments_model->delete_amendment();
	}
	
	//delete payment details
	public function delete_payment_transaction( $id = NULL ){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		//admin manager or accounts team
		if( ($role == 99 || $role ==98 || $role == 93 ) && isset( $_POST['id'] ) ){
			$del = $this->global_model->delete_data("iti_payment_transactions", array("tra_id" => $_POST['id'] ));
			if( $del ){
				$res = array('status' => true, 'msg' => "Transation delete Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Error.");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Error.");
		}
		die( json_encode($res) );
	}
	
	//update iti payment confirmed status
	public function ajax_payment_confirm_updateStatus( $id = NULL ){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		//admin manager or accounts team
		if( ($role == 99 || $role == 98 || $role == 93 ) && isset( $_POST['id'] ) ){
			$up = $this->global_model->update_data("iti_payment_details", array("id" => $_POST['id'] ), array('payement_confirmed_status' => 1 ));
			if( $up ){
				$res = array('status' => true, 'msg' => "Status Update successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Error.");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Error.");
		}
		die( json_encode($res) );
	}
	
	//edit trasaction details
	public function edit_payment_tra_data(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		//admin manager or accounts team
		if( ($role == 99 || $role ==98 || $role == 93 ) && isset( $_POST['id'] ) && !empty( $_POST['tra_amount'] ) ){
			$pay_amount 	= $this->input->post("tra_amount", TRUE);
			$einvoice_date 	= $this->input->post("einvoice_date", TRUE);
			$tra_bank_name 	= $this->input->post("tra_bank_name", TRUE);
			$e_t_payment_type = $this->input->post("e_t_payment_type", TRUE);
			$id			 = $this->input->post("id", TRUE);
			
			//update data
			$up_data = array(
				"bank_name" 		=> $tra_bank_name,
				"payment_received"	=> $pay_amount,
				"payment_type" 		=> $e_t_payment_type,
				"invoice_date"		=> $einvoice_date,
			);
			
			$update_data = $this->global_model->update_data("iti_payment_transactions", array("tra_id" => $_POST['id'] ), $up_data );
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Transation updated Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Error.");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Error.");
		}
		die( json_encode($res) );
	}
	
}	
?>