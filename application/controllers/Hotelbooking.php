<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Hotelbooking extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("hotelbooking_model");
		$this->load->model("itinerary_model");
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/all_hotelbooking');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	/* Book Hotel */
	public function add(){
		$req_id = $this->uri->segment(3);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		
		//check if all booking confirmed by agent
		$check_all_hotel_booking = is_hotel_booking_done( $req_id );
		if( $check_all_hotel_booking ){
			echo "You can't create new booking for this itinerary. Because All booking status has been updated.For more info contact your administrator.";
			die;
		}
		
		//Get Existing Bookings
		$where = array("iti_id" => $req_id , "del_status" => 0 );
		$exist_booking = $this->global_model->getdata( "hotel_booking", $where );
		$data["existing_bookings"] = $exist_booking;
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("iti_id" => $req_id, "iti_status" => 9, 'del_status' => 0 );
			$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
			$data['agent_id'] = $user_id;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/add_hotelbooking', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}	
	}
	
	/* Edit hotel booking */
	public function edit(){
		$booking_id = $this->uri->segment(3);
		$iti_id = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'del_status' => 0 );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
			
			if( $user['role'] == 97 && $data['hotel_booking'][0]->is_approved_by_gm != 0  ){
				echo "You can't edit this booking because its already sent to GM for approve or approved by GM.";
				exit;
			}	
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/edit', $data);
			$this->load->view('inc/footer');
		}/* elseif($user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'agent_id' => $user_id );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/edit', $data);
			$this->load->view('inc/footer');
		} */else{
			redirect(404);
		}
	}
	
	/* View hotel booking */
	public function view(){
		$booking_id = $this->uri->segment(3);
		$iti_id = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['role'] = $user['role'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] = 93 ){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'del_status' => 0 );
			$where_iti = array( 'iti_id' => $iti_id, 'del_status' => 0 );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
			$data['hotel_booking_all'] = $this->global_model->getdata( 'hotel_booking', $where_iti );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/view', $data);
			$this->load->view('inc/footer');
		}
		
		/* elseif($user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'agent_id' => $user_id );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/view', $data);
			$this->load->view('inc/footer');
		} */
		else{
			redirect(404);
		}
	}
	
	/* View hotel booking */
	public function view_mail(){
		$booking_id = $this->uri->segment(3);
		$iti_id = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'del_status' => 0 );
			$where_iti = array( 'iti_id' => $iti_id, 'del_status' => 0 );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
			$data['hotel_booking_all'] = $this->global_model->getdata( 'hotel_booking', $where_iti );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/mail', $data);
			$this->load->view('inc/footer');
		}
		/* elseif($user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'agent_id' => $user_id );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/view', $data);
			$this->load->view('inc/footer');
		} */
		else{
			redirect(404);
		}
	}
	
	/* data table get all Hotel booking */
	public function ajax_hotelbooking_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '97'){
			$where = array();
			$list = $this->hotelbooking_model->get_datatables();
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $hotel_book) {
				$row_delete = "";
				$row_edit = "";
				$no++;
				$iti_id = $hotel_book->iti_id;
				$cus_id = $hotel_book->customer_id;
				$booking_id = $hotel_book->id;
				$hotel_id = $hotel_book->hotel_id;
				$hotel_name = get_hotel_name( $hotel_id );
				$room_cat = get_roomcat_name( $hotel_book->room_type );
				$city = get_city_name($hotel_book->city_id);
				$booking_status = $hotel_book->booking_status;
				if( $booking_status == 9 ){
					$status = "<a data-id={$hotel_book->id} title='Hotel Booking Approved' href='javascript:void(0)' class='btn btn-success ajax_booking_status'><i class='fa fa fa-thumbs-o-up' aria-hidden='true'></i> &nbsp; Approved</a>";
				}elseif( $booking_status == 8 ){
					$status = "<a data-id={$booking_id} title='Hotel Booking Declined' href='javascript:void(0)' class='btn btn-danger ajax_booking_status'><i class='fa fa fa-times' aria-hidden='true'></i> &nbsp; Declined</a>";
				}elseif( $booking_status == 7 ){
					$status = "<strong class='red'><i class='fa fa-window-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
				}
				else{
					$status = "No Review";
				}
				/* count hotel booking sent status */
				$hotel_book_sent = $hotel_book->email_count;
				$sent_status = $hotel_book_sent > 0 ? "$hotel_book_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $hotel_book->id;
				$row[] = $hotel_book->iti_id;
				$row[] = get_customer_name($hotel_book->customer_id);
				$row[] = $city; 
				$row[] = $hotel_name;
				$row[] = $room_cat;
				$row[] = $hotel_book->check_in . " - " . $hotel_book->check_out; 
				$row[] = $hotel_book->total_cost; 
				$row[] = $sent_status; 
			
				if( empty($booking_status) && $hotel_book_sent > 0 ){
					$row[] = "<a title='Click to Approve Hotel Booking' href=" . site_url("confirm/hotelbooking?hotel_id=". base64_url_encode($hotel_id) . "&iti_id=" . base64_url_encode($iti_id) . "&token_key=" . base64_url_encode($booking_id) ) . "&status=" . base64_url_encode(9) . " class='btn btn-success' ><i class='fa fa fa-check' aria-hidden='true'></i></a>
					<a title='Click to Decline' href=" . site_url("confirm/hotelbooking?hotel_id=". base64_url_encode($hotel_id) . "&iti_id=" . base64_url_encode($iti_id) . "&token_key=" . base64_url_encode($booking_id) ) . "&status=" . base64_url_encode(8) . " class='btn btn-danger' ><i class='fa fa fa-ban' aria-hidden='true'></i></a>";
				}else{
					$row[] = $status;
				}
				
				if( is_admin() ){ 
					$row_delete = "<a data-id={$booking_id} title='Delete Hotel Booking' href='javascript:void(0)' class='btn btn-danger ajax_delete_booking'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
				}
				
				$view_mail = "<a title='Mail view' href=" . site_url("hotelbooking/view_mail/{$booking_id}/{$iti_id}") . " class='btn btn-success' >Mail View</a>";
				
				$edit = "";
				if( ( $role == 97 && $hotel_book->is_approved_by_gm == 0 ) || is_gm() || $role == 99  ){
					$edit = "<a title='edit' href=" . site_url("hotelbooking/edit/{$booking_id}/{$iti_id}") . " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}	
				
				$row[] = "<a title='View' href=" . site_url("hotelbooking/view/{$booking_id}/{$iti_id}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>" . $edit . $row_delete . $view_mail;
				$row[] = get_user_name($hotel_book->agent_id); 
				
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->hotelbooking_model->count_all($where),
			"recordsFiltered" => $this->hotelbooking_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/****************** Hotel Booking start here ******************/
	public function ajax_book_hotel(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '97'){
			$room_cost = $this->input->post('room_rates');	
			$total_cost = $this->input->post('total_cost');	
			$total_rooms = $this->input->post('total_rooms');
			$check_in	= $this->input->post('check_in');
			$check_out	= $this->input->post('check_out');
			if( $check_in == $check_out ){
				$res = array('status' => false, 'msg' => "Failed! Check In and Checkout Date not be same.");
				die(json_encode($res));
			}
			if( !is_numeric($room_cost) || empty($room_cost) || $room_cost == 0 ){
				$res = array('status' => false, 'msg' => "Failed! Please select other hotel/room category or Contact Administrator/Manager.");
				die(json_encode($res));
			}
			if( !is_numeric($total_cost) || empty($total_cost) || $total_cost == 0 ){
				$res = array('status' => false, 'msg' => "Failed! Please Calculate Total cost.");
				die(json_encode($res));
			}
			if( !is_numeric($total_rooms) || empty($total_rooms) || $total_rooms == 0 ){
				$res = array('status' => false, 'msg' => "Failed! Select Rooms.");
				die(json_encode($res));
			}
			if( isset($_POST["hotelcity"]) && !empty($_POST["hotel"])){
				$result = $this->hotelbooking_model->insert_hotelbooking();
				if( $result ){
					$this->session->set_flashdata('success',"Hotel Booking Added successfully.");
					$res = array('status' => true, 'msg' => "Hotel Booking add successfully!", "booking_id" => $result);
				}else{
					$res = array('status' => false, 'msg' => "Failed! Please try again later.");
				}
			}else{
				$res = array('status' => false, 'msg' => "Failed! Fill all fields.");
			}
			die(json_encode($res));
		}	
	}
	
	//edit hotel booking request
	public function ajax_edit_book_hotel(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '97'){
			$id						= strip_tags($this->input->post('id', TRUE));
			$hotel_id				= strip_tags($this->input->post('hotel', TRUE));
			$invoice_id				= strip_tags($this->input->post('invoice_id', TRUE));
			$room_type				= strip_tags($this->input->post('room_type', TRUE));
			$total_travellers		= strip_tags($this->input->post('total_travellers', TRUE));
			$check_in				= strip_tags($this->input->post('check_in', TRUE));
			$check_out				= strip_tags($this->input->post('check_out', TRUE));
			$inclusion				= strip_tags($this->input->post('inclusion', TRUE));
			$meal_plan				= strip_tags($this->input->post('meal_plan', TRUE));
			$room_cost				= strip_tags($this->input->post('room_rates', TRUE));		
			$total_rooms			= strip_tags($this->input->post('total_rooms', TRUE));
			$extra_bed_cost			= strip_tags($this->input->post('extra_bed_rate', TRUE));		
			$extra_bed				= strip_tags($this->input->post('extra_bed', TRUE));		
			$inclusion_cost			= strip_tags($this->input->post('extra_charges', TRUE));
			$hotel_tax				= strip_tags($this->input->post('hotel_tax', TRUE));
			$total_cost				= strip_tags($this->input->post('total_cost', TRUE));
			$city					= strip_tags($this->input->post('hotelcity', TRUE));
			$state_id				= strip_tags($this->input->post('state_id', TRUE));
			$without_extra_bed		= strip_tags($this->input->post('without_extra_bed', TRUE));		
			$without_extra_bed_cost	= strip_tags($this->input->post('without_extra_bed_cost', TRUE));		
			
			$data_array= array(
				'hotel_id'			=> $hotel_id,		
				'invoice_id'		=> $invoice_id,		
				'city_id'			=> $city,		
				'state_id'			=> $state_id,		
				'total_travellers'	=> $total_travellers,		
				'total_rooms'		=> $total_rooms,	
				'room_cost'			=> $room_cost,		
				'extra_bed'			=> $extra_bed,		
				'extra_bed_cost'	=> $extra_bed_cost,
				'without_extra_bed'	=> $without_extra_bed,
				'without_extra_bed_cost'	=> $without_extra_bed_cost,
				'inclusion_cost'	=> $inclusion_cost,
				'check_in'			=> $check_in,		
				'check_out'			=> $check_out,		
				'meal_plan'			=> $meal_plan,		
				'inclusion'			=> $inclusion,		
				'room_type'			=> $room_type,		
				'hotel_tax'			=> $hotel_tax,		
				'total_cost'		=> $total_cost,	
			);
			
			if( $check_in == $check_out ){
				$res = array('status' => false, 'msg' => "Failed! Check In and Checkout Date not be same.");
				die(json_encode($res));
			}
			
			if( !is_numeric($room_cost) || empty($room_cost) || $room_cost == 0 ){
				$res = array('status' => false, 'msg' => "Failed! Please select other hotel/room category or Contact Administrator/Manager.");
				die(json_encode($res));
			}
			if( !is_numeric($total_cost) || empty($total_cost) || $total_cost == 0 ){
				$res = array('status' => false, 'msg' => "Failed! Please Calculate Total cost.");
				die(json_encode($res));
			}
			if( !is_numeric($total_rooms) || empty($total_rooms) || $total_rooms == 0 ){
				$res = array('status' => false, 'msg' => "Failed! Select Rooms.");
				die(json_encode($res));
			}
			
			if( isset($_POST["hotelcity"]) && !empty($_POST["hotel"])){
				
				//CHECK IF APPROVED BY GM
				/*
				if( isset( $_POST['approve_pending'] ) && $_POST['approve_pending'] == 1 ){
					$check_old_price = $this->global_model->getdata("hotel_booking", array("id" => $id ) );
					$data_array['room_cost_old_by_agent'] = $check_old_price[0]->room_cost;
					$data_array['is_approved_by_gm'] = 2;
					$iti_id = $check_old_price[0]->iti_id;
					$customer_id = $check_old_price[0]->customer_id;
					$agent_id = $check_old_price[0]->agent_id;
					
					//SEND MAIL TO HOTEL TEAM
					$hotel_booking_email = hotel_booking_email();
					$admins 		= array( $hotel_booking_email );
					//sent mail to agent after price updated
					$link = "<a class='btn btn-success' target='_blank' href=" . site_url("hotelbooking/view/{$id}/{$iti_id}") . " title='View'>Click to view Booking</a>";					
					$sub 			= "Hotel Booking Quotation Approved By GM <Trackitinerary.org>";
					$msg 			= "Hotel booking quotation approved by GM. Now you can send this booking to Hotel for confirmation.<br>";
					$msg 			.= "Itinerary Id: {$iti_id} <br>";
					$msg 			.= "{$link}<br>";
					//send mail to manager 
					$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
					
					//NOTIFICATION TO SERVICE TEAM
					$title 		= "Hotel Booking Quotation Approved";
					$c_date 	= current_datetime();
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
					$body 		= "Hotel Booking Quotation Approved By GM";
					$notif_link = "hotelbooking/view/{$id}/{$iti_id}";
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 97, //97 = service team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $agent_id,
					);
					$this->global_model->insert_data( "notifications", $notification_data );
					//end  notification
				} */
				$where = array("id" => $id);
				$result = $this->global_model->update_data("hotel_booking", $where, $data_array);
				if( $result ){
					$this->session->set_flashdata('success',"Hotel Booking Edit successfully.");
					$res = array('status' => true, 'msg' => "Hotel Booking Edit successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Failed! Please try again later.");
				}
				die(json_encode($res));
			}else{
				$res = array('status' => false, 'msg' => "Failed! Fill all fields.");
				die(json_encode($res));
			}
		}	
	}
	
	//Send hotel booking confirmation email
	public function senthotelbooking(){
		$id = $this->input->post("id", true);
		$hotel_id = $this->input->post("hotel_id", true);
		$subject = strip_tags( $this->input->post("subject", true) );
		
		//$id = 2;
		//$hotel_id = 516;
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			/* //check if empty id and hotel id */
			if( empty($id) && empty($hotel_id)  ){
				$res = array('status' => false, 'msg' => "Invalid Id.");
				die( json_encode($res) );
			}
			
			$where = array( 'id' => $id , 'hotel_id' => $hotel_id );
			$hotel_bookings = $this->global_model->getdata( 'hotel_booking', $where );
			$data['hotel_booking'] = $hotel_bookings;
			$hotel_book = $hotel_bookings[0];
			$booking_id = $hotel_book->id;
			$iti_id = $hotel_book->iti_id;
			
			/* // Get Customer Information */
			$cust_info = get_customer($hotel_book->customer_id);
			$customer_info = $cust_info[0];
			$customer_name = $customer_info->customer_name;
			$customer_contact = $customer_info->customer_contact;
			
			/* //Get Hotel Information */
			$htl_info = get_hotel_details($hotel_book->hotel_id);;
			$hotel_info = $htl_info[0];
			$hotel_name = $hotel_info->hotel_name;
			$hotel_emails = array($hotel_info->hotel_email);
			/* Check if hotel Email is empty */
			if( empty( $hotel_emails ) ){
				$res = array('status' => false, 'msg' => "Hotel Email Id Does Not Exists Or Invalid.");
				die( json_encode($res) );
			}
			
			/* //get message template */
			$data['show_approved_btn'] = true;
			$message = $this->load->view("hotelbooking/mail", $data, TRUE);
			
			//Get admin emails
			//$admin_email = admin_email();
			$manager_email = manager_email();
			$from = hotel_booking_email();
			$bccEmails = array($manager_email);
			$cc = "";
			$sent_mail = sendEmail($hotel_emails, $subject, $message, $bccEmails, $cc="", $from );
			
			if( $sent_mail ){
				/* send msg for on Hotel booking */
				$hotel_email = $hotel_info->hotel_email;
				$mobile_hotelbooking_sms = "{$hotel_name}, Hotel booking email send to your email {$hotel_email}. If you not receive email in your inbox please find the mail in spam. Thanks <Track Itinerary Pvt Ltd.>";
				$hotel_mob = "{$hotel_info->hotel_contact}";
				if( !empty( $hotel_mob ) ){
					$sendhotel_sms = pm_send_sms( $hotel_mob, $mobile_hotelbooking_sms );
				}
		
				/* Get total email sent to current hotel bookin */
				$where = array( "id" => $booking_id );
				$count_email = $this->global_model->getdata( "hotel_booking", $where, "email_count" );
				if( empty($count_email) ){
					$count_email = 0;
				}
				$email_inc = $count_email+1;
				
				/* //update Email count status */
				$up_data = array(
					'email_count' => $email_inc,
				);
				$where_hotel_booking = array( "id" => $booking_id );
				$this->global_model->update_data( "hotel_booking", $where_hotel_booking, $up_data ); 
				$res = array('status' => true, 'msg' => "Hotel Booking Mail Sent Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Mail Not Sent. Please Try Again Later.");
			}
			die( json_encode($res) );
		}else{
			redirect(404);
		}
	}
	
	//Cancel Hotel Booking
	public function cancel_hotel_booking(){
		$id = $this->input->post("id", TRUE);
		$subject = strip_tags( $this->input->post("subject", true) );
		$comment = strip_tags( $this->input->post("comment", true) );
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array( 'id' => $id);
			$hotel_bookings = $this->global_model->getdata( 'hotel_booking', $where );
			$data['hotel_booking'] = $hotel_bookings;
			$hotel_book = $hotel_bookings[0];
			$booking_id = $hotel_book->id;
			$iti_id = $hotel_book->iti_id;
			
			// Get Customer Information 
			$cust_info = get_customer($hotel_book->customer_id);
			$customer_info = $cust_info[0];
			$customer_name = $customer_info->customer_name;
			$customer_contact = $customer_info->customer_contact;
			
			//Get Hotel Information
			$htl_info = get_hotel_details($hotel_book->hotel_id);;
			$hotel_info = $htl_info[0];
			$hotel_name = $hotel_info->hotel_name;
			$hotel_emails = array($hotel_info->hotel_email);
			
			//Check if hotel Email is empty
			if( empty( $hotel_emails ) ){
				$res = array('status' => false, 'msg' => "Hotel Email Id Does Not Exists Or Invalid.");
				die( json_encode($res) );
			}
			
			//get message template
			$message = $this->load->view("hotelbooking/mail_cancel_booking", $data, TRUE);
			
			//echo $message;
			//die();
			//Get admin emails
			//$admin_email = admin_email();
			$manager_email = manager_email();
			$hotel_booking_email = hotel_booking_email();
			$from_email = $hotel_booking_email;
			
			$bccEmails = array($manager_email, $hotel_booking_email);
			$sent_mail = sendEmail($hotel_emails, $subject, $message, $bccEmails, $cc="", $from_email ); 
			
			$where = array("id" => $id );
			//7=cancel booking
			$update_d = $this->global_model->update_data("hotel_booking", $where, array("booking_status" => 7, "booking_cancel_note" => $comment ) );
			if( $update_d){
				$this->session->set_flashdata('success',"Booking Cancel Successfully.");
				$res = array('status' => true, 'msg' => "Booking Cancel Successfully" );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Invalid Request!");
		}
		die(json_encode($res));
	}
	
		
	//Update cancel status
	public function ajax_update_cancelstatus(){
		$id = $this->input->post('id');	
		$comment = strip_tags($this->input->post('comment'));	
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			$data = array("booking_status" => 7,  "booking_cancel_note" => $comment );
			$where = array("id" => $id);
			$result = $this->global_model->update_data("hotel_booking", $where, $data);
			if( $result ){
				$this->session->set_flashdata('success',"Hotel Booking Cancel successfully.");
				$res = array('status' => true, 'msg' => "Hotel Booking Update successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	/* clone hotel booking */
	function duplicate_hotel_booking(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 || $user['role'] == 97 ){
			$booking_id = $this->uri->segment(3);
			$get_status = $this->global_model->getdata("hotel_booking", array("id" => $booking_id), "booking_status" );
			//7=canecled
			if( $get_status == 7 || $get_status == 8 ){
					$insert_id = $this->hotelbooking_model->duplicate_hotel_booking("hotel_booking", "id", $booking_id);
					if( $insert_id ){
						$getNewIti =  $this->global_model->getdata('hotel_booking', array("id" => $insert_id ) );
						$cloned_booking = $getNewIti[0];	
						$iti_id = $cloned_booking->iti_id;
						//redirect to edit page
						$redirect_url = site_url("hotelbooking/edit/{$insert_id}/{$iti_id}");
						redirect( $redirect_url );
						exit;
					}else{
						echo "Error";
					}
			}else{
				echo "Hotel Booking must be canceled for clone.";
			}	
		}else{
			redirect("dashboard");
		}	
	}
	
	//pending confirmation request for manager
	function pending_confirmation_request(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 99 || is_gm() ){
			$where = array( 'is_approved_by_gm' => 1, 'del_status' => 0, 'booking_status' => 0 );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where , "", "id");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotelbooking/pending_bookings', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("404");
		}	
	}
	
	//sent request to GM
	public function ajax_send_quotaion_to_gm(){
		$id = $this->input->post('id');
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			$get_booking_data = $this->global_model->getdata("hotel_booking", array("id" => $id ) );
			$iti_id = $get_booking_data[0]->iti_id;
			$lead_id = $get_booking_data[0]->customer_id;
			
			//SEND MAIL TO GM
			$gm_email 	= get_gm_email();
			$admins 	= array( $gm_email );
			//sent mail to agent after price updated
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("hotelbooking/view/{$id}/{$iti_id}") . " title='View'>Click to view Booking</a>";					
			$sub 			= "New hotel booking quotation request.<Trackitinerary.org>";
			$msg 			= "Hotel booking quotation approval request sent by agent. Please review quotation by click on below link and confirm.<br>";
			$msg 			.= "Itinerary Id: {$iti_id} <br>";
			$msg 			.= "Lead Id: {$lead_id} <br>";
			$msg 			.= "{$link}<br>";
			//send mail to manager 
			$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
			
			$data = array("is_approved_by_gm" => 1 );
			$where = array("id" => $id);
			$result = $this->global_model->update_data("hotel_booking", $where, $data);
			if( $result ){
				$this->session->set_flashdata('success',"Hotel Booking Quotation sent successfully to GM.");
				$res = array('status' => true, 'msg' => "Hotel Booking not sent successfully!");
				
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			
			die(json_encode($res));
		}	
	}
	
}	

?>